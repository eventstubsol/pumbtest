import React, { Component } from "react";
import ReactDOM from "react-dom";
import PollResults from "./PollResults";
import moment from "moment";
import CountDown from "../utils/countdown";
import PollForm from "./PollForm";


const $ = window.$ || window.jQuery;

const {
    token,
    sessionId,
    session,
    pollListRoute,
    showOnlyResult = false,
    poll: resultPoll,
} = window.config;

class App extends Component{
    state = {
        delegatesCount: 100,
        delegatesOnline: 50,
        session: session,
        status: 0,
        pollStatus: -1,
        pollForm: false,
        poll: false,
        pollActive: false,
        showResults: false,
        onlineUsers: 0,
        activeUsers: 0,
    };

    getPollDetails(){
        if(showOnlyResult){ return; }
        this.setState({
            loadingPoll: true
        });
        $.ajax({
            url: pollListRoute,
            data: {
                _token: token
            },
            success: (response) => {
                if(response && response.poll && response.poll.id){
                    this.setState({
                        pollActive: response.poll.status == 1,
                        showResults: response.poll.status == 2 && !this.state.pollForm,
                        poll: response.poll,
                        onlineUsers: response.onlineUsers || 0,
                        activeUsers: response.activeUsers || 0,
                        loadingPoll: false,
                    });
                }else if(response.onlineUsers || response.activeUsers){
                    this.setState({
                        onlineUsers: response.onlineUsers || 0,
                        activeUsers: response.activeUsers || 0,
                        loadingPoll: false,
                    })
                }
            },
            error: (err) => {
                console.log("Failed to fetch current session ongoing motion");
                console.log(err)
                this.setState({
                    loadingPoll: false,
                });
            }
        });
    }

    componentDidMount() {
        if(showOnlyResult){ return; }
        this.updateStatus();
        this.getPollDetails();
        setInterval(this.updateStatus, 1000);
    }

    markPollEnded = () => {
        this.setState({
            poll: false,
            pollActive: false,
            showResults: false,
        });
        setTimeout(this.getPollDetails, 1000);
    };

    updateStatus = () => {
        const {
            start_time,
            end_time
        } = session;
        /**
         * -1 = Ended
         * 0 = not started
         * 1 = started
         * @type {number}
         */
        let status = 0; //Not Started
        let now = moment();
        if(moment(start_time).isBefore(now) && moment(end_time).isAfter(now)){
            status = 1;
        }else if(moment(end_time).isBefore(now)){
            status = -1;
        }
        this.setState({
            status
        })
    };

    openPollForm = () => {
        this.setState({
            pollForm: true,
            showResults: false,
        });
    };

    handleCancelPoll = () => {
        this.setState({ pollForm: false });
    };

    handleCreatePoll = (poll) => {
        this.setState({
            pollForm: false,
            poll,
            pollActive: true,
        });
    };

    updatePollStatus(status){
        let { poll } = this.state;
        poll.status = status;
        this.setState({
            poll,
        });
    }

    render(){
        if(showOnlyResult){ return <PollResults
            markPollEnded={this.markPollEnded}
            poll={resultPoll}
        />; }

        const {
            status,
            session,
            pollStatus,
            pollForm,
            pollActive,
            poll,
            showResults,
            onlineUsers,
            activeUsers,
            loadingPoll,
        } = this.state;

        const {
            start_time,
            end_time
        } = session;

        return (

            <div>
                {
                    status >= 0 ? <CountDown time={parseInt(moment(status === 0 ? start_time : end_time).format("x"))} /> : null
                }
                {
                    status === 1 ?
                        <>
                            <h2>Session is on</h2>
                            <button disabled={loadingPoll} onClick={() => this.getPollDetails()} className="btn btn-primary mb-2"><i className="fe-refresh-cw mr-1" /> Refresh</button>
                            <div className="row">
                                {
                                    !showOnlyResult ?
                                        <div className="col-lg-6 col-xl-6">
                                            <div className="card-box bg-pattern">
                                                <div className="row">
                                                    <div className="col-6">
                                                        <div className="avatar-md bg-success rounded">
                                                            <i className="fe-user-check avatar-title font-22 text-white"/>
                                                        </div>
                                                    </div>
                                                    <div className="col-6">
                                                        <div className="text-right">
                                                            <h3 className="text-dark my-1"><span
                                                                data-plugin="counterup">{onlineUsers}</span></h3>
                                                            <p className="text-muted mb-0 text-truncate">Delegates Online</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    : null
                                }
                                {/*{*/}
                                {/*    !showOnlyResult ?*/}
                                {/*        <div className="col-lg-6 col-xl-6">*/}
                                {/*            <div className="card-box bg-pattern">*/}
                                {/*                <div className="row">*/}
                                {/*                    <div className="col-6">*/}
                                {/*                        <div className="avatar-md bg-success rounded">*/}
                                {/*                            <i className="fe-user-check avatar-title font-22 text-white"/>*/}
                                {/*                        </div>*/}
                                {/*                    </div>*/}
                                {/*                    <div className="col-6">*/}
                                {/*                        <div className="text-right">*/}
                                {/*                            <h3 className="text-dark my-1"><span*/}
                                {/*                                data-plugin="counterup">{activeUsers}</span></h3>*/}
                                {/*                            <p className="text-muted mb-0 text-truncate">Delegates In Auditorium</p>*/}
                                {/*                        </div>*/}
                                {/*                    </div>*/}
                                {/*                </div>*/}
                                {/*            </div>*/}
                                {/*        </div>*/}
                                {/*        : null*/}
                                {/*}*/}
                            </div>
                            {
                                pollStatus !== 1 && !pollForm && !pollActive ? <button onClick={this.openPollForm} className="btn btn-primary">Create Motion</button> : null
                            }
                            {
                                pollForm && !(pollActive || showResults)? <PollForm
                                    handleCancelPoll={this.handleCancelPoll}
                                    handleCreatePoll={this.handleCreatePoll}
                                /> : null
                            }
                        </>
                        : <h2>
                            {
                                status === 0 ? "Session is yet to begin" : "Session has ended"
                            }
                        </h2>
                }
                {
                    pollActive || showResults ? <PollResults
                        markPollEnded={this.markPollEnded}
                        poll={poll}
                    /> : null
                }
            </div>
        );
    }
}

const domElId = "sessions-poll-app";
if (document.getElementById(domElId)) {
    ReactDOM.render(<App />, document.getElementById(domElId));
}