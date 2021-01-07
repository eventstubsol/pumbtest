import React from "react";
import "./style.scss";

import { CometChat } from "@cometchat-pro/chat";
import { CometChatManager } from "../../util/controller";

import NavBar from "./NavBar";
import CometChatMessageListScreen from "../CometChatMessageListScreen";
import CometChatUserDetail from "../CometChatUserDetail";
import CometChatGroupDetail from "../CometChatGroupDetail";
import {SvgAvatar} from "../../util/svgavatar";

let chatOpeningFunction;
let openChat = (which) => {
  if(chatOpeningFunction && typeof chatOpeningFunction === "function"){
    chatOpeningFunction(which);
  }else{
    return "SDK not initialized. Try after some time.";
  }
};
window.openChat = openChat;

class CometChatUnified extends React.Component {
  constructor(props) {
    super(props);
    this.handleHashChange = this.handleHashChange.bind(this);
  }
  
  state = {
    darktheme: false,
    viewdetailscreen: false,
    item: {},
    type: "user",
    tab: "conversations",
  };

  changeTheme = (e) => {
    this.setState({
      darktheme: !this.state.darktheme
    })
  };

  componentDidMount() {
    window.addEventListener("hashchange", this.handleHashChange)
    this.handleHashChange();
    chatOpeningFunction = (which) => {
      this.fetchUser(which);
    }
  }

  handleHashChange(){
    let boothHash = "#booth/";
    let hash = window.location.hash;
    if(hash.startsWith(boothHash)){
      let boothId = hash.substr(boothHash.length);
      if(window.config.booths.hasOwnProperty(boothId)){
        //Booth exists, now open group chat
        this.fetchBoothChat(boothId, window.config.booths[boothId]);
      }
    }else if(hash === "#lounge"){
        this.fetchBoothChat("public-chat", "General Chat");
    }else if(hash === "#auditorium"){
        this.fetchBoothChat("auditorium", "Auditorium");
    }else if(hash === "#workshop"){
        this.fetchBoothChat("workshop", "Workshop");
    }
  }

  fetchBoothChat(boothId, boothName, group = false){
    CometChat.getGroup(boothId).then(
        group => {
          this.joinBoothChat(group);
        },
        error => {
          if(error && error.code === "ERR_GUID_NOT_FOUND"){
            this.createBoothChat(boothId, boothName);
          }
        }
    );
  }

  createBoothChat(boothId, groupName){
    const groupType = CometChat.GROUP_TYPE.PUBLIC;
    const password = "";

    const group = new CometChat.Group(boothId, groupName, groupType, password);

    CometChat.createGroup(group).then(
        group => {
          this.joinBoothChat(group);
        },
        error => {
          //Do nothing
          console.log("Error joining booth chat:", boothId)
        }
    );
  }

  joinBoothChat(group){
    this.setAvatar(group);
    if (!group.hasJoined) {
      let GUID = group.guid;
      let password = "";
      let groupType = CometChat.GROUP_TYPE.PUBLIC;

      CometChat.joinGroup(GUID, groupType, password).then(
          group => {
            //this.groupUpdated(group);
            this.itemClicked(group, 'group');
          },
          error => {
            console.log("Group joining failed with exception:", error);
          }
      );

    } else {
      this.itemClicked(group, 'group');
    }

  }

  fetchUser(id){
    CometChat.getUser(id).then(user => {
      this.joinUserChat(user);
    }).catch(err =>{
      console.log("Error occurred while fetching user.");
      console.log(err)
    })
  }

  joinUserChat(user){
    this.itemClicked(user, 'user');
    $("body").addClass("right-bar-enabled");
    $(".loader").hide();
  }

  setAvatar(group) {

    if(!group.getIcon()) {

      const guid = group.getGuid();
      const char = group.getName().charAt(0).toUpperCase();
      group.setIcon(SvgAvatar.getAvatar(guid, char))
    }

  }


  navBarAction = (action, type, item) => {
    
    switch(action) {
      case "itemClicked":
        this.itemClicked(item, type);
      break;
      case "tabChanged":
        this.tabChanged(type);
      break;
      case "groupMemberLeft":
        this.appendMessage(item);
      break;
      case "groupMemberJoined":
        this.appendMessage(item);
      break;
      case "userStatusChanged":
        this.updateSelectedUser(item);
      break;
      default:
      break;
    }
  }

  updateSelectedUser = (item) => {

    this.setState({ item: {...item}});
  }

  itemClicked = (item, type) => {
    this.setState({ item: {...item}, type, viewdetailscreen: false });
  }

  tabChanged = (tab) => {
    this.setState({tab});
    this.setState({viewdetail: false});
  }

  viewDetailActionHandler = (action) => {
    
    switch(action) {
      case "blockUser":
        this.blockUser();
      break;
      case "unblockUser":
        this.unblockUser();
      break;
      case "viewDetail":
        this.toggleDetailView();
      break;
      default:
      break;
    }
  }

  blockUser = () => {

    let usersList = [this.state.item.uid];
    CometChatManager.blockUsers(usersList).then(list => {

        this.setState({item: {...this.state.item, blockedByMe: true}});

    }).catch(error => {
      console.log("Blocking user fails with error", error);
    });

  }

  unblockUser = () => {
    
    let usersList = [this.state.item.uid];
    CometChatManager.unblockUsers(usersList).then(list => {

        this.setState({item: {...this.state.item, blockedByMe: false}});

      }).catch(error => {
      console.log("unblocking user fails with error", error);
    });

  }

  toggleDetailView = () => {

    if(this.state.type === "user") {
      let viewdetail = !this.state.viewdetailscreen;
      this.setState({viewdetailscreen: viewdetail});
    }
  }
  
  render() {
    let detailScreen;
    if(this.state.viewdetailscreen) {

      if(this.state.type === "user") {

        detailScreen = (
          <div className="ccl-right-panel">
            <CometChatUserDetail
              item={this.state.item} 
              type={this.state.type}
              actionGenerated={this.viewDetailActionHandler} />
          </div>);

      } else if (this.state.type === "group") {

        detailScreen = (
          <div className="ccl-right-panel">
          <CometChatGroupDetail
            item={this.state.item} 
            type={this.state.type}
            actionGenerated={this.viewDetailActionHandler} />
          </div>
        );
      }
    }

    let messageScreen = (<h1>Select a chat to start messaging</h1>);
    if(Object.keys(this.state.item).length) {
      messageScreen = (<CometChatMessageListScreen 
        item={this.state.item} 
        tab={this.state.tab}
        type={this.state.type}
        actionGenerated={this.viewDetailActionHandler}>
      </CometChatMessageListScreen>);
    }
    
    return (
      <div className="page-wrapper">
        <div className="page-int-wrapper">
          <div className="ccl-left-panel">
            <NavBar 
              item={this.state.item} 
              tab={this.state.tab} 
              actionGenerated={this.navBarAction} />
          </div>
          <div className="ccl-center-panel ccl-chat-center-panel">{messageScreen}</div>
          {detailScreen}
        </div>
        
      </div>
    );
  }
}

export default CometChatUnified;