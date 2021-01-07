import React from 'react';
import logo from './logo.svg';
import { CometChat } from "@cometchat-pro/chat";
import { CometChatUnified } from "./CometChat";
import ReactDOM from 'react-dom';

const {
    appID,
    region,
    authKey,
} = window.config.cometChat;

const $ = window.$ || window.jQuery;

const hideChat = () => $ && $("body").removeClass("right-bar-enabled");

class App extends React.Component{
    constructor(props) {
        super(props);
        this.state = {
            uid: window.config.userId,
            user: false,
            initializedChat: false,
            loginError: false,
        };
    }

    fetchUnreadMessagesCount(){
        CometChat.getUnreadMessageCountForAllUsers().then((data) => {
            let totalCount = Object.values(data).reduce((a, b) => a + (parseInt(b) || 0), 0);
            if(totalCount && typeof $ === "function"){
                $("#chat-unread-count").removeClass("hidden").html(totalCount);
            }
        }).catch(() => {});
    }

    handleUserLogin(){
        const { uid } = this.state;
        CometChat.login(uid, authKey).then(
            user => {

                this.setState({
                    initializedChat: true,
                    user
                });
                // user.setAvatar(window.config.profileImage);
                // CometChat.updateUser(user, authKey);
                this.fetchUnreadMessagesCount();
            },
            error => this.handleUserLoginError(error)
        );
    }

    handleUserLoginError = error => {
        console.log("Login Error", error)
        //Creating if new user does not exist
        if(error && error.code === "ERR_UID_NOT_FOUND"){
            const { uid } = this.state;
            const user = new CometChat.User(uid);
            user.setName(window.config.userName);
            CometChat.createUser(user, authKey).then(
                user => {
                    this.setState({
                        initializedChat: true,
                        user
                    });
                },error => {
                    this.setState({
                        loginError: true
                    });
                    console.log("error", error);
                }
            );
        }else{
            this.setState({
                loginError: true
            });
            console.log("Login failed with exception:", { error });
        }
    };

    componentDidMount() {
        const appSetting = new CometChat.AppSettingsBuilder().subscribePresenceForAllUsers().setRegion(region).build();
        const { uid } = this.state;
        CometChat.init(appID, appSetting).then(
            () => {
                this.handleUserLogin();
            },
            error => {
                console.log("Initialization failed with error:", error);
                // Check the reason for error and take appropriate action.
            }
        );
    }

    render(){
        const {
            user,
            initializedChat,
        } = this.state;
        return (
            <>
                {
                    initializedChat ?
                        <CometChatUnified/> :
                        <div className="chat-loader">
                            <i className="mdi mdi-spin mdi-loading mr-2" />
                        </div>
                }
                <div className="close" onClick={hideChat}>&times;</div>
            </>
        );
    }
}

if (document.getElementById('chat-container')) {
    ReactDOM.render(<App />, document.getElementById('chat-container'));
}

export default App;
