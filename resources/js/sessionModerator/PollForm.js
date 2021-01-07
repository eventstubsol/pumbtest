import React, { Component } from "react";
import CKEditor from 'ckeditor4-react';

const {
    confirmDelete,
    swal,
    config: {
        token,
        pollCreateRoute,
    }
} = window;

const initialState = {
    time: "2",
    questions: [
        {
            question: '',
            options: [
                "Aye",
                "Naye",
            ],
        }
    ],
    publishing: false,
};

class PollForm extends Component{
    state = { ...initialState };

    handleQuestionUpdate = qI => (question) => {
        let { questions } = this.state;
        if(questions[qI]){
            questions[qI].question = question;
            this.setState({
                ...questions
            });
        }
    };

    handleTimerUpdate = (e) => this.setState({ time: e.target.value });

    handleOptionChange = (qI, index) => e => {
        let { questions } = this.state;
        if(questions[qI]){
            let { options } = questions[qI];
            options[index] = e.target.value;
            questions[qI].options = options;
            this.setState({
                ...questions
            });
        }
    };

    handleAddOption = (qI) => {
        let { questions } = this.state;
        if(questions[qI]){
            questions[qI].options.push("");
            this.setState({
                ...questions
            });
        }
    };

    handleOptionDelete = (qI, index) => () => {
        let { questions } = this.state;
        if(questions[qI]){
            let { options } = questions[qI];
            if(options.length > 2){
                if(options[index].length){
                    confirmDelete("Are you sure you want to delete this option?", "Please confirm").then(confirmed => {
                        if(confirmed){
                            options.splice(index, 1);
                            questions[qI].options = options;
                            this.setState({
                                ...questions
                            });

                        }
                    });
                }else{
                    options.splice(index, 1);
                    questions[qI].options = options;
                    this.setState({
                        ...questions
                    });
                }
            }
            else{
                Swal.fire({
                    title: "Cannot remove option",
                    text: "You need to have at-least 2 options to run a motion!",
                    type: "warning",
                    confirmButtonColor: "#3085d6",
                });
            }
        }


    };

    handleCancelPoll = () => {
        confirmDelete("Are you sure you want to cancel making a motion?", "Please confirm").then(confirmed => {
            if(confirmed){
                this.props.handleCancelPoll();
            }
        });
    };

    handlePollPublish = () => {
        let isValid = true;
        let message = "";
        let {
            questions,
            time,
        } = this.state;
        const {
            handleCreatePoll,
        } = this.props;
        questions.map((questionSingle, qI) => {
            const {
                question, options
            } = questionSingle;
            if(isValid && question.length < 10){
                message = `The question text for question ${qI + 1} very short. Please add more content in question.`;
                isValid = false;
            }
            if(isValid){
                options.map(option => {
                    isValid = isValid && option.length;
                });
                if(!isValid){
                    message = `One or more options are blank for question ${qI + 1}. Please add some content to option before publishing the motion.`;
                }
            }
        });
        if(isValid){
            this.setState({
                publishing: true
            });
            confirmDelete("Are you sure you want to push the motion live? This will be showed to all the attendees in the session room", "Please confirm", {
                type: "info",
                confirmButtonText: "Publish"
            }).then(confirmed => {
                if(confirmed){
                    $.ajax({
                        url: pollCreateRoute,
                        method: "POST",
                        data:{
                            _token: token,
                            questions,
                            time,
                        },
                        success: (response) => {
                            this.setState({
                                publishing: false
                            });
                            if(response && response.poll){
                                Swal.fire({
                                    title: "Motion Published",
                                    text: "Published the motion sucessfully",
                                    type: "success",
                                });
                                handleCreatePoll(response.poll);
                            }else{
                                Swal.fire({
                                    title: "Error",
                                    text: response.message || "Some error occurred while publishing Motion!",
                                    type: "error",
                                });
                            }
                            console.log(response)
                        },
                        error: (err) => {
                            this.setState({
                                publishing: false
                            });
                            console.log(err);
                            Swal.fire({
                                title: "Error",
                                text: "Some error occurred while publishing Motion!",
                                type: "error",
                            });
                        }
                    });
                }else{
                    this.setState({
                        publishing: true
                    });
                }
            });
        }else{
            Swal.fire({
                title: "Cannot publish motion",
                text: message,
                type: "warning",
                confirmButtonColor: "#3085d6",
            });
        }
    };

    addQuestion = () => {
        let { questions } = this.state;
        questions.push({
            question: "",
            options: [ "", "" ],
        });
    };

    render(){
        const {
            questions,
            options,
            time,
            publishing,
        } = this.state;
        return <>
            <div className="row">
                <div className="col-md-12">
                    <div className="card">
                        <div className="card-header">
                            <h4 className="card-title d-flex justify-content-between align-items-center">
                                New Motion
                                <button className={"btn btn-primary"} onClick={this.addQuestion}>Add Question</button>
                            </h4>
                        </div>
                        <div className="card-body">

                            <div className="row">
                                {
                                    questions.map((questionSingle, questionIndex) => {
                                        const {
                                            question,
                                            options
                                        } = questionSingle;
                                        return (
                                            <div className="col-md-12">
                                                <div className="form-group">
                                                    <label className="form-label">Question {questionIndex + 1}</label>
                                                    <QuestionInput onChange={this.handleQuestionUpdate(questionIndex)} value={question} />
                                                </div>
                                                <label className="form-label">Options</label>
                                                {
                                                    options.map((option, index) => {
                                                        return <div className="form-group" key={"option"+index}>
                                                            <div className="input-group">
                                                                <input type="text" className="form-control" onChange={this.handleOptionChange(questionIndex, index)} value={option} />
                                                                <div className="input-group-append" onClick={this.handleOptionDelete(questionIndex, index)}>
                                                        <span className="input-group-text">
                                                            <i className="fe-delete" />
                                                        </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    })
                                                }
                                                <div className="form-group mt-2 text-right">
                                                    <button className="btn btn-primary mr-2" onClick={() => this.handleAddOption(questionIndex)}>
                                                        <i className="fe-plus mr-2"/> Add Option
                                                    </button>
                                                </div>
                                                <hr/>
                                            </div>
                                        );
                                    })
                                }
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="timing" className="form-label">Timer</label>
                                        <select name="timing" id="timing" value={time} className="form-control" onChange={this.handleTimerUpdate}>
                                            <option value="2">2 Minutes</option>
                                            <option value="10">10 Minutes</option>
                                        </select>
                                    </div>
                                    <div className="form-group mt-2">
                                        <button className="btn btn-primary mr-2" onClick={this.handlePollPublish} disabled={publishing}>
                                            {
                                                publishing ? <span className="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" /> : null
                                            }
                                            {
                                                publishing ? "Publishing" : "Publish Motion"
                                            }
                                        </button>
                                        <button className="btn btn-primary mr-2" onClick={this.handleCancelPoll}  disabled={publishing}>
                                            Cancel
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>;
    }
}

function QuestionInput({ value, onChange }){
    return <CKEditor
        config={ {
            extraPlugins: 'colorbutton'
        } }
        data={value}
        onChange={event =>{
            if(event && event.editor && event.editor.getData()){
                onChange(event.editor.getData())
            }
        }}
    />
}

export default PollForm;