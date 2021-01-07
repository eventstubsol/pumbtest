import React, { Component } from "react";
import ReactDOM from "react-dom";
import Session from "./session";
import moment from "moment";

const defaultSession = {
    id: false,
    name: "New Session",
    description: "",
    start_time: "",
    end_time: "",
    room: window.config.sessionRooms[0],
    type: window.config.sessionTypes[0],
    vimeo_url: "",
    zoom_webinar_id: "",
    zoom_password: "",
    speakers: [],
};

const $ = window.$ || window.jQuery;

const {
    sessionSaveRoute,
    token,
    sessions,
} = window.config;

const confirmDelete = window.confirmDelete;

class App extends Component{
    state = {
        sessions: sessions,
        activeIndex: 0
    };

    addNewSession = () => {
        this.setState({
            activeIndex: this.state.sessions.length,
            sessions: [
                ...this.state.sessions,
                { ...defaultSession }
            ],
        })
    };

    deleteSession = (index) => () => {
        let { sessions } = this.state;
        confirmDelete("Are you sure you want to delete the session?", "Please confirm!").then(confirmed => {
            if(confirmed){
                confirmDelete("This action is non-reversible. Do you still want to proceed", "Think again!").then(confirmed => {
                    if(confirmed){
                        this.state.sessions.splice(index, 1);
                        this.setState({
                            sessions: [
                                ...sessions
                            ],
                        });
                    }
                });
            }
        });
    };

    openSession = (activeIndex) => this.setState({ activeIndex });

    handleChange = (index) => (prop, value, isArray = false, isFocusOut = false) => {
        const { sessions } = this.state;
        if(isArray){
            let v = [];
            value.target.selectedOptions.forEach(i => v.push(i.value));
            value = v;
        }
        sessions[index] = {
            ...sessions[index],
            [prop]: value
        };
        if(prop === "start_time" && sessions[index].end_time === "" && isFocusOut){
            sessions[index].end_time = moment(value).add(30, "m").format('Y-MM-DDTHH:mm');
        }
        this.setState({ sessions });
    };

    saveSessions = () => {
        const {
            sessions
        } = this.state;
        console.log(this.state.sessions);
        $.ajax({
            url: sessionSaveRoute,
            method: "POST",
            data: {
                sessions,
                _token: token,
            },
            success: function(response){
                console.log(response)
                alert("Saved Sessions")
            },
            error: function(err){
                console.log(err)
                alert("Some error occurred while saving sessions");
            }
        })
    };

    render(){
        const { sessions } = this.state;
        return (
            <div className="row">
                <div className="col-md-12">
                    <div id="accordion" className="mb-3">
                        {
                            sessions.map((session, index) => <Session
                                index={index}
                                session={session}
                                key={"session-"+index}
                                deleteSession={this.deleteSession(index)}
                                openSession={this.openSession}
                                handleChange={this.handleChange(index)}
                            />)
                        }
                    </div>
                </div>
                <div className="col-md-12 mb-3">
                    <button className="btn btn-primary" onClick={this.addNewSession}>
                        <i className="fe-plus mr-1"></i>
                        Add New Session
                    </button>
                    <button className="ml-2 btn btn-primary" onClick={this.saveSessions}>
                        <i className="fe-save mr-1"></i>
                        Save Sessions
                    </button>
                </div>
            </div>
        );
    }
}

const domElId = "sessions-app";
if (document.getElementById(domElId)) {
    ReactDOM.render(<App />, document.getElementById(domElId));
}