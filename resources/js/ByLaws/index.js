import React, { Component } from "react";
import ReactDOM from "react-dom";
import CountDown from '../utils/countdown';
import moment from "moment";

const $ = window.$;
const initialState = {
    loading: true,
    questions: [],
    hasVoted: false,
    isActive: 1,
    hasError: false,
    responses: {},
    startTime: false,
    endTime: false,
    showTImer: true,
    summaryMode: false,
};

class ByLaws extends Component{
    state = initialState;
    componentDidMount() {
        let {
            poll,
            listenForPollEnd,
        } = this.props;
        if(poll){
            this.setState({
                ...initialState,
                ...poll,
                loading: false,
                startTime: parseInt(moment(poll.startTime).format("x")),
                endTime: parseInt(moment(poll.startTime).add(poll.timer || "2", "minutes").format("x")),
            });
            if(typeof listenForPollEnd === "function"){
                listenForPollEnd(() => {
                    this.setState({
                        isActive: 2,
                    });
                    // let pollName = "motion";
                    // if(poll.questions && poll.questions.length > 1){
                    //     pollName = "ballot";
                    // }
                    let pollName = "Voting";
                    Swal({ type: "info", title: `${pollName} Ended`, text: `The ${pollName} has ended. You cannot vote for it now!` });
                });
            }
        }else{
            $.ajax({
                url: window.config.byLawsURL,
                data: {
                    _token: window.config.token,
                },
                success: (response) => {
                    this.setState({
                        ...response,
                        loading: false,
                        startTime: parseInt(moment(response.startTime).format("x")),
                        endTime: parseInt(moment(response.endTime).format("x")),
                    });
                },
                error: () => {
                    this.setState({
                        hasError: true,
                    });
                }
            })
        }
    }

    handlePollSubmission = (response) => {
        const { poll, onSubmit } = this.props;
        this.setState({
            submitting: true,
            responses: response
        });
        $.ajax({
            url: poll ? window.config.sessionPollSubmissionURL : window.config.byLawsSubmissionURL,
            method: "POST",
            data: {
                _token: window.config.token,
                response,
                poll: poll ? poll.id : false,
            },
            success: (response) => {
                if(response.error){
                    Swal({ type: "error", title: "Error!", text: response.message });
                }else{
                    Swal({ type: "success", title: "Success!", text: response.message });
                    this.setState({
                        hasVoted: true,
                        submitting: false,
                    });
                    if(poll && typeof onSubmit === "function"){
                        onSubmit();
                    }
                }
            },
            error: () => {
                this.setState({
                    hasError: true,
                    submitting: false,
                });
                Swal({ type: "error", title: "Error!", text: "Some error occurred while submitting your vote. Please try again!" });
            }
        });
    };

    handleOptionSelection = (question,option) => {
        if(!this.props.poll){
            $.ajax({
                url: window.config.byLawsOptionSubmissionURL,
                method: "POST",
                data: {
                    _token: window.config.token,
                    question,
                    option,
                },
            });
        }
        //We need not check for data returned or even give any feedback to user, we are just recording the selection. Even if it fails, it will be updated while submitting
    }


    render(){
        const {
            loading,
            hasVoted,
            questions,
            responses,
            isActive,
            submitting,
            startTime,
            endTime,
        } = this.state;
        const {
            poll = false,
        } = this.props;
        return (
            loading ? "Loading" :
                submitting ? "Submitting" :
                    isActive === 0 ? 
                    <div>
                        <p className="q-title mb-4">The TRI 2020 is yet to begin!</p>
                        <div className="buttons-wrapper has-border">
                            <div>
                                <CountDown time={startTime} forEvent={"Left For TRI 2020 to Start"} />
                            </div>
                            <div>
                                Please wait for the poll to start
                            </div>
                        </div>
                    </div> :
                        isActive === 2 ?  <p className="q-title mb-4">The {
                            poll ?
                                "Voting"
                            : "TRI 2020"
                        } is completed</p> :
                            <Poll
                                hasVoted={hasVoted}
                                questions={questions}
                                onSelection={this.handleOptionSelection}
                                onSubmit={this.handlePollSubmission}
                                responses={responses}
                                endTime={endTime}
                                poll={poll}
                            />
        );
    }
}

class Poll extends Component{
    constructor(props) {
        super(props);
        let questionIndex = 0;
        if(props.responses && Object.keys(props.responses).length ){
            questionIndex = Object.keys(props.responses).length; //Taking user directly to the question from where he left off in previous session
            if(props.questions.length <= questionIndex){
                questionIndex = props.questions.length - 1;
            }
        }
        this.state = {
            questionIndex,
            showMessage: false,
            started: false || props.poll || props.hasVoted || questionIndex > 0,
            responses: props.responses || {},
        };
    }

    goToPrev = () => this.setState({ questionIndex: this.state.questionIndex - 1 });

    goToNext = () => {
        const {
            questionIndex,
            responses
        } = this.state;
        const {
            questions,
            poll = false,
        } = this.props;
        if(poll && !responses.hasOwnProperty(questions[questionIndex].id)){
            this.setState({
                showMessage: "Please select one option before proceeding!",
            });
        }else{
            this.setState({
                questionIndex: this.state.questionIndex + 1,
                showMessage: false,
            });
        }
    }

    startVoting=  () => this.setState({ started: true, questionIndex: 0 });;

    selectOption = (questionID) => (optionId) => () => {
        let { poll = false } = this.props;
        if(this.props.hasVoted){
            this.setState({
                showMessage: "You have already voted! Cannot change the response now",
            });
            return;
        }
        this.props.onSelection(questionID,optionId);
        this.setState({
            showMessage: false,
            responses: {
                ...this.state.responses,
                [questionID]: optionId,
            }
        })
    };

    submitPoll = () => {
        const {
            hasVoted,
            questions,
            onSubmit,
            poll = false,
        } = this.props;
        if(hasVoted){
            this.setState({
                showMessage: "You have already voted for the "+(
                    poll ?
                        "Voting"
                        : "TRI 2020"
                )+"!",
            });
        }else{
            if(poll && !Object.keys(this.state.responses).length === questions.length){
                this.setState({
                    showMessage: "Please answer all questions before proceeding!",
                });
            }else{
                onSubmit(this.state.responses);
            }
        }
    };

    handleTimerComplete = () => {
        const {
            poll = false,
        } = this.props;
        if(poll){
            this.setState({
                showTImer: false
            });
        }
    };

    openSummaryMode = () => {
        this.setState({
            summaryMode: true,
        });
    };

    render() {
        const {
            questions,
            hasVoted,
            endTime,
            poll = false,
        } = this.props;
        const {
            started,
            questionIndex,
            responses,
            showMessage,
            summaryMode = false,
        } = this.state;
        const question = questions[questionIndex];
        return started && question ?
            <>
                {
                    showMessage ? <div className={"alert alert-warning has-icon info"}>{showMessage}</div> :
                    hasVoted ? <div className="alert alert-info has-icon info">You have already voted! You can browse through the responses you provided here.</div> : null
                }
                {
                    !poll && !summaryMode ? <p className="q-index">Question {questionIndex + 1}</p> : null
                }
                {
                    poll || summaryMode ?
                        questions.map((question, index) =>
                            <Question index={(index + 1)+". "} key={index} question={question} selectedOption={responses[question.id]} onOptionSelect={this.selectOption(question.id)} />
                        ) :
                        <Question index={""} question={question} selectedOption={responses[question.id]} onOptionSelect={this.selectOption(question.id)} />
                }

                <div className="buttons-wrapper">
                    <div>
                        {
                            !summaryMode && !poll?
                                questionIndex >= questions.length - 1 ? <button onClick={this.openSummaryMode}>View Summary</button> : null
                                : <button onClick={this.submitPoll} hidden={(hasVoted || questionIndex !== questions.length - 1) && !poll}>Vote</button>
                        }

                        <div className="time has-icon timer"><i className="" /><CountDown onComplete={this.handleTimerComplete} time={endTime} forEvent={""} /></div>
                    </div>
                    <div>
                        <button onClick={this.goToPrev} hidden={summaryMode || questionIndex <= 0 || poll} disabled={questionIndex <= 0}>Prev</button>
                        <button onClick={this.goToNext} hidden={summaryMode || questionIndex >= questions.length - 1 || poll}>Skip</button>
                        <button onClick={this.goToNext} hidden={summaryMode || questionIndex >= questions.length - 1 || poll}>Next</button>
                    </div>
                </div>
            </>:
            <>
                <p className="q-title mb-4">
                    {hasVoted ? "Please click on View Response to check the result" : "Please click on Start to Vote the TRI 2020" }
                </p>
                <div className="buttons-wrapper has-border">
                    <div>
                        <div className="time has-icon timer"><i className=""></i><CountDown time={endTime} forEvent={""} /></div>
                    </div>
                    <div>
                        <button className="filled" onClick={this.startVoting}>
                            {hasVoted?"View Responses":"Start Voting"}
                        </button>
                    </div>
                </div>
            </>
    }
}

function Question({ question, selectedOption, onOptionSelect, index  }){
    return <>
        <p className="q-title" dangerouslySetInnerHTML={{ __html: question.text }} />
        <ul className="q-options">
            {
                question.options.map(option => {
                    return <li key={option.id} className="radio">
                        <input id={option.id} onChange={onOptionSelect(option.id)} type="radio" name={option.id} value={option.id} checked={option.id === selectedOption} />
                        <label htmlFor={option.id}>
                            {option.text}
                        </label>
                    </li>
                })
            }
        </ul>
    </>;
}

if (document.getElementById('by-laws-poll')) {
    ReactDOM.render(<ByLaws />, document.getElementById('by-laws-poll'));
}

const startPoll = (poll, callback, listenForPollEnd) => {
    if (document.getElementById('delegate-poll')) {
        let el = document.getElementById('delegate-poll');
        const onSubmit = () => {
            ReactDOM.unmountComponentAtNode(el);
            if(typeof callback === "function"){
                callback();
            }
        };
        listenForPollEnd(() => {
            let pollName = "Voting";
            Swal({ type: "info", title: `${pollName} Ended`, text: `The ${pollName} has ended. You cannot vote for it now!` });
            ReactDOM.unmountComponentAtNode(el);
        });
        ReactDOM.render(<ByLaws poll={poll} onSubmit={onSubmit} />, el);
    }
};

window.startPoll = startPoll;