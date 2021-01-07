import React, {Component} from "react";
import ReactDOM, { createPortal } from "react-dom";
import ProfileInfo from "./Components/ProfileInfo";
import Invitations from "./Components/Invitations";
import EditProfile from "./Components/EditProfile";
import Contacts from "./Components/Contacts";
import 'react-toastify/dist/ReactToastify.css';
import "@material/react-chips/dist/chips.css";
import { ToastContainer, toast } from 'react-toastify';

const $ = window.$;
const {
    profileURL,
} = window.config || {};
const initialState = {
    loading: false,
    ...window.config.profile
};
const mountingElement = "profile-app";

const actionToasts = {};

const showToast = (action, title,type = "info", options = {}) => {
    let timeNow = Date.now();
    if(actionToasts.hasOwnProperty(action) && actionToasts[action] + 15000 > timeNow){
        console.log("Suppressing notification since it of same type within 15 seconds.");
        return false;
    }
    actionToasts[action] = timeNow;
    let validTypes = ["info", "success", "warn", "error"];
    let toastFunc = validTypes.includes(type) ? toast[type] : toast;
    toastFunc(title, {
        ...options,
        position: "bottom-left",
        autoClose: 5000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: false,
    });
};

window.showToast = showToast;

class Profile extends Component {
    state = {
        ...initialState,
        editMode: false,
        notifications: {},
    };

    componentDidMount() {
        this.fetchProfileInfo();
        this.watchForNotifications();
    }

    watchForNotifications = () => {
        window.listenForChanges("notifications", (newNotifications) => {
            let { notifications } = this.state;
            let newOnes = {};
            newNotifications.map(n => {
                if(!notifications.hasOwnProperty(n.id)){
                    if(!newOnes.hasOwnProperty(n.action_type)){
                        newOnes[n.action_type] = [];
                    }
                    newOnes[n.action_type].push(n)
                }
                notifications[n.id] = {
                    ...notifications[n.id],
                    ...n,
                }
            });
            Object.keys(newOnes).map((action) => {
                let notif = newOnes[action][0];
                let title = notif.title;
                let type = notif.type;
                let options = {};
                switch(action){
                    case "connection_received":
                        if(newOnes[action].length > 1){
                            title += ` and ${newOnes[action].length - 1} others`;
                        }
                        if(!notif.action_id){
                          return false;
                        }
                        options.onClick = () => {
                            window.showProfile(notif.action_id);
                        };
                        break;
                    case "suggested_user_login":
                        options.onClick = () => {
                            window.routie("attendees");
                        };
                        break;
                    case "session_reminder":
                        if(notif.details){
                            action = action+"-"+notif.action_id
                            options.onClick = () => {
                                window.routie(notif.details);
                            };
                        }
                        break;
                }
                showToast(action, title, type, options);
            });
            this.setState({
                notifications
            });
        });
    };

    fetchProfileInfo = () => {
        this.setState({
            loading: true,
        });
        $.ajax({
            url: profileURL,
            success: (response) => {
                if (response && typeof response.user === "object") {
                    this.setState({
                        ...response,
                        loading: false,
                    });
                } else {
                    this.setState({
                        loading: false,
                    });
                }
            },
            error: (err) => {
                console.log(err)
                showMessage("Profile fetching failed! Please try again in some time.", "error");
                this.setState({
                    loading: false,
                });
            }
        })
    };

    editProfile = () => {
        this.setState({
            editMode: !this.state.editMode,
        });
        this.fetchProfileInfo();
    };

    render() {
        const {
            user,
            editMode,
        } = this.state;
        return <div className="container">
            <div className="row">
                <div className="col-lg-4 col-xl-4">
                    <ProfileInfo user={user} edit={this.editProfile}  refresh={this.fetchProfileInfo}  />
                    <Invitations />
                </div>
                <div className="col-lg-8 col-xl-8">
                    {
                        editMode ? <EditProfile user={user} onSave={this.editProfile} /> : <Contacts editProfile={this.editProfile} />
                    }
                </div>
            </div>
            <ToastPortal/>
        </div>;
    }
}

function ToastPortal(){
    return createPortal(
        <ToastContainer
            position="bottom-left"
            autoClose={5000}
            hideProgressBar
            newestOnTop
            closeOnClick={false}
            pauseOnFocusLoss
            draggable={false}
            pauseOnHover
        />,
        document.querySelector("body")
    );
}

if (document.getElementById(mountingElement)) {
    ReactDOM.render(<Profile/>, document.getElementById(mountingElement));
}