import React from "react";
import "./style.scss";

import Avatar from "../../Avatar";
import { SvgAvatar } from '../../../util/svgavatar';

const messageheader = (props) => {

  let status, image;
  if(props.type === "user") {

    // if(!props.item.avatar) {
    //
    //   const uid = props.item.getUid();
    //   const char = props.item.getName().charAt(0).toUpperCase();
    //
    //   props.item.setAvatar(SvgAvatar.getAvatar(uid, char));
    // }

    status = props.item.status;
    image = props.item.avatar;

  } else {

    if(!props.item.icon && typeof props.item.getGuid === "function" && typeof props.item.getName === "function") {
      const guid = props.item.getGuid();
      const char = props.item.getName().charAt(0).toUpperCase();

      props.item.setIcon(SvgAvatar.getAvatar(guid, char))
    }

    status = props.item.type;
    image = props.item.icon;
  }

  return (
    <div className="cc1-chat-win-header clearfix">
      <div className="cc1-chat-win-user">
        <div className="cc1-chat-win-user-thumb">
          <Avatar
          image={image}
          cornerRadius="18px"
          borderColor="#CCC"
          borderWidth="1px"></Avatar>
        </div>
        <div className="cc1-chat-win-user-name-wrap">
          <h6 className="cc1-chat-win-user-name">{props.item.name}</h6>
          <span className="cc1-chat-win-user-status ccl-blue-color">{status}</span>
        </div>
      </div>
    </div>
  )
}

export default React.memo(messageheader);