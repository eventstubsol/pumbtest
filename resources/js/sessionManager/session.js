import React, { Component } from "react";
import moment from "moment";


class Session extends Component{
    render(){
        const {
            sessionTypes = [],
            // sessionRooms = [],
            // moderatorUsers = [],
            speakerUsers = [],
        } = window.config || {};

        const sessionRooms = {
            "AUDITORIUM":"AUDITORIUM",
            "WORKSHOP":"WORKSHOP",
        };
        const {
            index,
            session,
            handleChange,
            deleteSession,
        } = this.props;

        const {
            name,
            description,
            start_time,
            end_time,
            room,
            type,
            vimeo_url,
            zoom_webinar_id,
            zoom_password,
            // moderators,
            speakers,
            past_video,
        } = session;
        let date_range = "";
        if(start_time && end_time){
            let s = moment(start_time);
            let e = moment(end_time);
            //Check if it is on same day
            if(s.clone().endOf("d").isSame(e.clone().endOf("d"))){
                date_range = s.format("ddd, Do MMM h:m A") + " - " + e.format("h:m A") + " / "+ e.clone().diff(s, "minutes") + " mins";
            }else{
                date_range = s.format("ddd, Do MMM h:m A") + " - " + e.format("ddd, Do MMM h:m A");
            }
        }
        if(date_range){
            date_range = `(${date_range})`;
        }
        return (
            <div className="card mb-2">
                <a className="text-dark" data-toggle="collapse" href={"#collapse-"+index}>
                    <div className="card-header" id={"heading-"+index}>
                        <h5 className="m-0">
                            {index + 1}. {name} {date_range}
                            <div className="card-widgets">
                                <span onClick={deleteSession}><i className="mdi mdi-close" /></span>
                            </div>
                        </h5>
                    </div>
                </a>
                <div id={"collapse-"+index} className="collapse" aria-labelledby={"heading-"+index} data-parent="#accordion" >
                    <div className="card-body">
                        <div className="row">
                            <div className="col-md-12">
                                <div className="form-group">
                                    <label className="form-label">Title</label>
                                    <input type="text" onChange={e => handleChange("name", e.target.value)} value={name} className="form-control"/>
                                </div>
                            </div>
                            <div className="col-md-12">
                                <div className="form-group">
                                    <label className="form-label">Description</label>
                                    <textarea onChange={e => handleChange("description", e.target.value)} value={description} className="form-control"/>
                                </div>
                            </div>
                            <div className="col-md-6">
                                <div className="form-group">
                                    <label className="form-label">Type</label>
                                    <select name="type" value={type}  onChange={e => handleChange("type", e.target.value)}  className="form-control">
                                        {
                                            sessionTypes.map(typeAvailable => <option value={typeAvailable} key={typeAvailable}>{typeAvailable.replace("_", " ")}</option>)
                                        }
                                    </select>
                                </div>
                            </div>
                            <div className="col-md-6">
                                <div className="form-group">
                                    <label className="form-label">Room</label>
                                    <select name="type" value={room} onChange={e => handleChange("room", e.target.value)} className="form-control">
                                        {
                                            Object.keys(sessionRooms).map(roomAvailable => <option value={roomAvailable} key={roomAvailable}>{sessionRooms[roomAvailable].toUpperCase()}</option>)
                                        }
                                    </select>
                                </div>
                            </div>
                            <div className="col-md-6">
                                <div className="form-group">
                                    <label className="form-label">Start Time</label>
                                    <input value={start_time} type="datetime-local" className="form-control"
                                           onChange={e => handleChange("start_time", e.target.value)}
                                           onBlur={e => handleChange("start_time", e.target.value, false, true)}  />
                                </div>
                            </div>
                            <div className="col-md-6">
                                <div className="form-group">
                                    <label className="form-label">End Time</label>
                                    <input value={end_time} type="datetime-local" onChange={e => handleChange("end_time", e.target.value)} className="form-control"/>
                                </div>
                            </div>
                            <div className="col-md-12">
                                <div className="form-group">
                                    <label className="form-label">Vimeo URL</label>
                                    <input type="url" value={vimeo_url} onChange={e => handleChange("vimeo_url", e.target.value)} className="form-control"/>
                                </div>
                            </div>
                            <div className="col-md-12">
                                <div className="form-group">
                                    <label className="form-label">Zoom Webinar Id</label>
                                    <input type="number" value={zoom_webinar_id} onChange={e => handleChange("zoom_webinar_id", e.target.value)} className="form-control"/>
                                </div>
                            </div>
                            <div className="col-md-12">
                                <div className="form-group">
                                    <label className="form-label">Zoom Webinar Password</label>
                                    <input type="string" value={zoom_password} onChange={e => handleChange("zoom_password", e.target.value)} className="form-control"/>
                                </div>
                            </div>
                            <div className="col-md-12">
                                <div className="form-group">
                                    <label className="form-label">Past Video Recording</label>
                                    <input type="string" value={past_video} onChange={e => handleChange("past_video", e.target.value)} className="form-control"/>
                                </div>
                            </div>
                            {/*<div className="col-md-12">*/}
                            {/*    <div className="form-group">*/}
                            {/*        <label className="form-label">Moderators</label>*/}
                            {/*        <select onChange={e => handleChange("moderators", e)} className="form-control" multiple>*/}
                            {/*            {*/}
                            {/*                moderatorUsers.map(user => {*/}
                            {/*                    return <option selected={moderators.includes(user.id)} value={user.id} key={user.id}>{user.name} ({user.email})</option>*/}
                            {/*                })*/}
                            {/*            }*/}
                            {/*        </select>*/}
                            {/*    </div>*/}
                            {/*</div> */}
                            <div className="col-md-12">
                                <div className="form-group">
                                    <label className="form-label">Speakers</label>
                                    <select onChange={e => handleChange("speakers", e, true)} className="form-control" multiple>
                                        {
                                            speakerUsers.map(user => {
                                                return <option selected={speakers.includes(user.id)} value={user.id} key={user.id}>{user.name} ({user.email})</option>
                                            })
                                        }
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Session;