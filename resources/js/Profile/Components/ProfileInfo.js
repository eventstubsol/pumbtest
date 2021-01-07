import React, { useState, useEffect } from "react";
import {ChipSet, Chip} from '@material/react-chips';

const {
    userId,
    sendConnectionURL,
    updateConnectionURL,
    token,
    addToContactURL,
    removeContactURL,
} = window.config || {};

const assetUrl = window.assetUrl;
const recordEvent = window.recordEvent;

const openChat = window.openChat;

function ProfileInfo({ user, refresh = false, edit = false, updateStatus = false }){
    let [isUpdating, setUpdating] = useState(false);
    let [isAdding, setAdding] = useState(false);
    useEffect(() => {
        // Update the document title using the browser API
        let tooltip = $('.show-email-tooltip');
        if(tooltip && tooltip.length && typeof tooltip.tooltip === "function"){
            tooltip.tooltip();
        }
    });
    function sendConnectionRequest(user){
        recordEvent("connection_request_sent","Sent Connection Request", "attendees_interaction");
        setUpdating(true);
        $.ajax({
            url: sendConnectionURL,
            method: "POST",
            data: {
                _token: token,
                user,
            },
            success: (response) => {
                setUpdating(false);
                if(response.success && typeof updateStatus === "function"){
                    delete response.success;
                    updateStatus(user, response);
                }
            },
            error: (err) => {
                console.log(err);
                setUpdating(false);
            }
        });
    }

    function updateRequest(connection, status = 1){
        if(status){
            recordEvent("connection_request_accepted","Accepted Connection Request", "attendees_interaction");
        }else{
            recordEvent("connection_request_declined","Declined Connection Request", "attendees_interaction");
        }
        setUpdating(true);
        $.ajax({
            url: updateConnectionURL,
            method: "POST",
            data: {
                _token: token,
                connection,
                status,
            },
            success: (response) => {
                setUpdating(false);
                if(response.success && typeof updateStatus === "function"){
                    delete response.success;
                    user.connection_status = response.connection_status === 1;
                    updateStatus(user.id, response);
                }
            },
            error: (err) => {
                console.log(err);
                setUpdating(false);
            }
        });
    }

    function UserActions({ user }){
        if('connection_type' in user && 'connection_status' in user){
            if(user.connection_status === -1){
                return <p>{user.connection_type === "sent" ? "Declined" : "You Declined"}</p>;
            }
            if(user.connection_status === 1){
                return <p><button type="button" className="btn btn-danger btn-xs waves-effect mb-2 waves-light" onClick={() => openChat(user.id)}>Message </button></p>;
            }
            return <p>{
                user.connection_type === "sent" ?
                    "Pending" :
                    isUpdating ? "Updating" :
                    <>
                        <button disabled={isUpdating} type="button" className="btn btn-outline-primary btn-xs waves-effect mb-2 waves-light mr-2" onClick={() => updateRequest(user.connection_id, 1)}>{isUpdating ? "Accepting" : "Accept"}</button>
                        <button disabled={isUpdating} type="button" className="btn btn-outline-danger btn-xs waves-effect mb-2 waves-light" onClick={() => updateRequest(user.connection_id, -1)}>{isUpdating ? "Declining" : "Decline"}</button>
                    </>
            }</p>;
        }
        return <p><button type="button" className="btn btn-danger btn-xs waves-effect mb-2 waves-light" onClick={() => sendConnectionRequest(user.id)}>{isUpdating ? "Sending Request" : "Connect"}</button></p>;
    }

    function updateContact(user, is_contact = true){
        setAdding(true);
        if(is_contact){
            recordEvent("contact_saved","Saved Contact", "attendees_interaction");
        }else{
            recordEvent("contact_removed","Removed contact", "attendees_interaction");
        }
        $.ajax({
            url: is_contact ? addToContactURL : removeContactURL,
            method: "POST",
            data: {
                _token: token,
                user,
            },
            success: function (response) {
                if(response.success && typeof updateStatus === "function"){
                    updateStatus(user, {
                        is_contact,
                    });
                }
                setAdding(false);
            },
            error: function(err){
                console.log(err);
                setAdding(false);
            }
        });
    }

    function UserContactStatus({ user }){
        if(user.is_contact){
            return <div><button type="button" className="btn btn-danger btn-xs waves-effect mb-2 waves-light" onClick={() => updateContact(user.id, false)}>{isAdding ? "Removing" : "Remove from Contacts"} </button></div>;
        }
        return <div><button type="button" className="btn btn-outline-primary btn-xs waves-effect mb-2 waves-light" onClick={() => updateContact(user.id, true)}>{isAdding ? "Saving" : "Save to Contact"}</button></div>;
    }

    const isEditable = userId === user.id && typeof edit === "function";
    return <div className="card-box text-center">
        <img src={assetUrl(user.profileImage || "uploads/default-profile.jpeg")} key={user.profileImage+"-"+user.id} className="rounded-circle avatar-lg img-thumbnail d-inline-block"
             alt="profile-image"/>
        <h4 className="mb-0">{user.name}</h4>
        <p className="text-muted mb-1">
            {user.job_title}
            {user.company_name ? " @ " : " "}
            {
                user.company_name && user.company_website_link ?
                    <a href={user.company_website_link} target="_blank">{user.company_name}</a>
                    : user.company_name
            }
        </p>
        {
            !isEditable ? <p className="mt-1 mb-1 text-muted font-12">
                <small className={"mdi mdi-circle "+(user.is_online ? "text-success" : "text-danger")} /> {user.is_online ? "Online" : "Offline"}
            </p> : null
        }
        {
            userId === user.id ?
                <>
                    {
                        isEditable ? <button type="button" onClick={edit} className="btn btn-success btn-xs waves-effect mb-2 waves-light mr-2">Edit </button> : null
                    }
                </> :
                <>
                    <UserActions user={user} />
                    <UserContactStatus user={user} />
                </>
        }

        <div className="text-left mt-3">
            <h4 className="font-13 text-uppercase">About Me :</h4>
            <p className="text-muted font-13 mb-3">{user.bio}</p>
            <p className="text-muted mb-2 font-13"><strong>Full Name :</strong> <span
                className="ml-2">{user.name} {user.last_name}</span></p>
            <p className="text-muted mb-2 font-13">
                <strong>Email :</strong>
                {
                    user.email ? <span className="ml-2 ">{user.email}</span> :
                        <a className="text-muted show-email-tooltip ml-2" data-toggle="tooltip" data-placement="top"
                           title="Connect with user to see email"
                           data-original-title="Connect with user to see email">
                            ****@****.***
                        </a>
                    }
            </p>
            {
                user.country ? <p className="text-muted mb-1 font-13"><strong>Location:</strong> <span
                    className="ml-2">{user.country}</span></p> : null
            }
            {
                isEditable ? <h4 className="font-13 text-uppercase mt-3 mb-2">My Tags:</h4> : null
            }
            <div className="mt-3">
                {
                    user.tags && Array.isArray(user.tags) ? <ChipSet>
                        {user.tags.map((chip) =>
                            <Chip
                                id={chip.id}
                                key={chip.id}
                                label={chip.tag}
                            />
                        )}
                    </ChipSet> : null
                }
            </div>
            {
                isEditable ?
                    <>
                        <h4 className="font-13 text-uppercase mt-3 mb-2">Looking for Tags:</h4>
                        <div>
                            {
                                user.looking_for_tags && Array.isArray(user.looking_for_tags) ? <ChipSet>
                                    {user.looking_for_tags.map((chip) =>
                                        <Chip
                                            id={chip.id}
                                            key={chip.id}
                                            label={chip.tag}
                                        />
                                    )}
                                </ChipSet> : null
                            }
                        </div>
                    </> : null
            }
        </div>

        <ul className="social-list list-inline mt-3 mb-0">
            {
                user.facebook_link ?
                    <li className="list-inline-item">
                        <a href={user.facebook_link} target="_blank"
                           className="social-list-item border-primary text-primary">
                            <i className="mdi mdi-facebook" />
                        </a>
                    </li> : null
            }{
            user.twitter_link ?
                <li className="list-inline-item">
                    <a href={user.twitter_link} target="_blank"
                       className="social-list-item border-primary text-primary">
                        <i className="mdi mdi-twitter" />
                    </a>
                </li> : null
        }
            {
                user.linkedin_link ?
                    <li className="list-inline-item">
                        <a href={user.linkedin_link} target="_blank"
                           className="social-list-item border-primary text-primary">
                            <i className="mdi mdi-linkedin" />
                        </a>
                    </li> : null
            }
            {
                user.website_link ?
                    <li className="list-inline-item">
                        <a href={user.website_link} target="_blank"
                           className="social-list-item border-primary text-primary">
                            <i className="mdi mdi-link" />
                        </a>
                    </li> : null
            }
        </ul>
    </div>
}

export default ProfileInfo;