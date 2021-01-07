import React from "react";
import Countdown from 'react-countdown';

function CountDown({ time, onComplete, forEvent }){
    const renderer = ({ days, hours, minutes, seconds }) => <span>{days}d {hours}h {minutes}m {seconds}s {forEvent}</span>;
    return <Countdown
        date={time}
        onComplete={onComplete}
        renderer={renderer}
    />
}

export default CountDown;