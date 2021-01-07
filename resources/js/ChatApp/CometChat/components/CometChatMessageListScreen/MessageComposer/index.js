import React from "react";
import classNames from "classnames";

import "./style.scss";

import { CometChat } from "@cometchat-pro/chat"

import roundedPlus from "./resources/rounded-plus-grey-icon.svg";
import sendBlue from "./resources/send-blue-icon.svg";

const $ = window.$ || window.jQuery;


class MessageComposer extends React.PureComponent {

  constructor(props) {
    super(props);
  
		this.imageUploaderRef = React.createRef();
		this.fileUploaderRef = React.createRef();
		this.audioUploaderRef = React.createRef();
    this.videoUploaderRef = React.createRef();
    this.messageInputRef = React.createRef();
	}

  state = {
    showFilePicker: false,
    messageInput: "",
    messageType: ""
  }
  
  changeHandler = (e) => {
    this.setState({"messageInput": e.target.value, "messageType": "text"});
  }

  toggleFilePicker = () => {
    const currentState = !this.state.showFilePicker;
    this.setState({ showFilePicker: currentState });
  }

  openFileDialogue = (fileType) => {

    switch (fileType) {
      case "image":
        this.imageUploaderRef.current.click();
        break;
      case "file":
          this.fileUploaderRef.current.click();
        break;
      case "audio":
          this.audioUploaderRef.current.click();
        break;
      case "video":
          this.videoUploaderRef.current.click();
        break;
      default:
        break;
    }
  }

  onImageChange = (e, messageType) => {

    if(!e.target.files[0]) {
      return false;
    }
    
    const imageInput = e.target.files[0];
    this.sendMediaMessage(imageInput, messageType)   
  }

  onFileChange = (e, messageType) => {

    if(!e.target.files[0]) {
      return false;
    }

    const fileInput = e.target.files[0];
    this.sendMediaMessage(fileInput, messageType)   
  }

  onAudioChange = (e, messageType) => {

    if(!e.target.files[0]) {
      return false;
    }

    const audioInput = e.target.files[0];
    this.sendMediaMessage(audioInput, messageType)   
  }

  onVideoChange = (e, messageType) => {

    if(!e.target.files[0]) {
      return false;
    }

    const videoInput = e.target.files[0];
    this.sendMediaMessage(videoInput, messageType)   
  }

  sendMediaMessage = (messageInput, messageType) => {

    this.toggleFilePicker();

    let receiverId;
    let receiverType = this.props.type;
    if (this.props.type === "user") {
      receiverId = this.props.item.uid;
    } else if (this.props.type === "group") {
      receiverId = this.props.item.guid;
    }

    let message = new CometChat.MediaMessage(receiverId, messageInput, messageType, receiverType);
    CometChat.sendMessage(message).then(message => {
      this.props.actionGenerated("messageComposed", [message])
    }).then(error => {
      console.log("Message sending failed with error:", error);
    });
  }

  sendMessageOnEnter = (e) => {

    if(e.key !== 'Enter')
      return false;

    this.sendTextMessage();
  }

  sendTextMessage = () => {

    if(!this.state.messageInput.trim().length) {
      return false;
    }

    let messageInput = this.state.messageInput.trim();

    let receiverId;
    let receiverType = this.props.type;
    if (this.props.type === "user") {
      receiverId = this.props.item.uid;
    } else if (this.props.type === "group") {
      receiverId = this.props.item.guid;
    }

    let textMessage = new CometChat.TextMessage(receiverId, messageInput, receiverType);
    CometChat.sendMessage(textMessage).then(message => {
      this.setState({messageInput: ""})
      this.props.actionGenerated("messageComposed", [message]);
    }).catch(error => {
      console.log("Message sending failed with error:", error);
    });
  }

  componentDidMount() {
    this.messageInputRef.current.focus();
    $(".cc1-chat-win-inpt-wrap input").unbind("mousedown").on("mousedown", function(e){ e.preventDefault(); e.stopImmediatePropagation(); $(e.target).focus() })
  }

  render() {

    let disabled = false;
    if(this.props.item.blockedByMe) {
      disabled = true;
    }

    const filePickerClassName = classNames({
      "cc1-chat-win-file-popup": true,
      "active": (this.state.showFilePicker)
    });

    return (

      <div className="cc1-chat-win-inpt-ext-wrap">
        
        <div className="cc1-chat-win-inpt-int-wrap">
          <div className="cc1-chat-win-inpt-attach" onClick={this.toggleFilePicker}>
            <span><img src={roundedPlus} alt="Click to upload a file" /></span>
          </div>
          <div className={filePickerClassName}>
            <div className="cc1-chat-win-file-type-list">
              <span className="cc1-chat-win-file-type-listitem video" onClick={() => { this.openFileDialogue("video") }}>
              <input onChange={(e) => this.onVideoChange(e, "video")} accept="video/*" type="file" ref={this.videoUploaderRef} />
              </span>
              <span className="cc1-chat-win-file-type-listitem audio" onClick={() => { this.openFileDialogue("audio") }}>
              <input onChange={(e) => this.onAudioChange(e, "audio")} accept="audio/*" type="file" ref={this.audioUploaderRef} />
              </span>
              <span className="cc1-chat-win-file-type-listitem image" onClick={() => { this.openFileDialogue("image") }}>
                <input onChange={(e) => this.onImageChange(e, "image")} accept="image/*" type="file" ref={this.imageUploaderRef} />
              </span>
              <span className="cc1-chat-win-file-type-listitem file" onClick={() => { this.openFileDialogue("file") }}>
              <input onChange={(e) => this.onFileChange(e, "file")} type="file" id="file" ref={this.fileUploaderRef} />
              </span>
            </div>
          </div>
          <div className="cc1-chat-win-inpt-wrap">
            <input 
            type="text"
            className="cc1-chat-win-inpt-box"
            placeholder="Enter your message here" 
            autoComplete="off" 
            disabled={disabled}
            onChange={this.changeHandler}
            onKeyDown={this.sendMessageOnEnter}
            value={this.state.messageInput}
            ref={this.messageInputRef} />
          </div>
          <div className="cc1-chat-win-inpt-send">
            <span className="cc1-chat-win-inpt-send-btn" onClick={this.sendTextMessage}><img src={sendBlue} alt="Send Message" /></span>
          </div>
        </div>
      </div>
    );
  }
}

export default MessageComposer;