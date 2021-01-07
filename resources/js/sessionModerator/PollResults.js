import React, {Component} from "react";
import ReactDOM from "react-dom";


const $ = window.$ || window.jQuery;

const {
    confirmDelete,
} = window;

const {
    token,
    pollResultRoute,
    pollResultViewRoute,
    pollStopRoute,
    showOnlyResult = false,
} = window.config;

class PollResults extends Component {
    state = {
        delegatesCount: 100,
        delegatesOnline: 50,
        loading: false,
        results: {},
        votesCount: 0,
        votersList: [],
        nonVotersList: [],
        interval: false,
        refreshing: false,
    };

    componentDidMount() {
        const {
            poll,
        } = this.props;
        this.fetchResults();
        if(showOnlyResult && poll && parseInt(poll.status) === 2){ return; }
        this.setState({
            interval: setInterval(this.fetchResults, 2500)
        });
    }

    componentWillUnmount() {
        if(this.state.interval){
            clearInterval(this.state.interval);
        }
    }

    fetchResults = () => {
        if(this.state.refreshing){ return false; }
        const {
            poll,
            markPollEnded,
        } = this.props;
        this.setState({
            refreshing: true
        });
        $.ajax({
            url: pollResultRoute,
            method: "POST",
            data: {
                poll: poll.id,
                _token: token,
            },
            success: (response) => {
                this.setState({
                    refreshing: false
                });
                if(response && response.success && response.result){
                    this.setState({
                        ...response.result,
                    });
                    if(response.status === 2){
                        markPollEnded();
                    }
                }else{
                    alert("Some error occurred. Please refresh the page to continue.")
                    clearInterval(this.state.interval);
                }
            },
            error: () => {
                this.setState({
                    refreshing: false
                });
            }
        })
    };

    stopPoll = () => {
        const {
            poll,
            markPollEnded,
        } = this.props;
        if(poll && poll.id){
            confirmDelete("Are you sure you want to stop the motion?", "Please confirm").then(confirmed => {
                if(confirmed){
                    $.ajax({
                        url: pollStopRoute,
                        method: "POST",
                        data:{
                            _token: token,
                            poll: poll.id,
                        },
                        success: function(){
                            alert("Motion Stopped successfully");
                            window.open(pollResultViewRoute.replace("pollIdReplacement", poll.id));
                            markPollEnded();
                        },
                        error: function(){
                            alert("Some error occurred while stopping the motion. Please try again!");
                        }
                    });
                }
            });
        }
    }

    render() {
        let {
            delegatesCount,
            votesCount,
            results,
            nonVotersList,
            votersList,
        } = this.state;

        const {
            poll,
        } = this.props;
        if(!poll){
            return "Loading";
        }
        let {
            name,
            status,
            questions,
        } = poll;

        let delegatesOnline = 0;
        if(votersList && votersList.length){
            votersList = votersList.map(user => {
                if(user.online_status == 2 && user.current_page !== "auditorium"){
                    user.online_status = 1;
                }
                return user;
            });
            delegatesOnline = votersList.filter(user => user.online_status == 2).length;
        }

        status = parseInt(status);

        return (
            <>
                <div className="row">
                    <div className="col-md-12">
                        <div className="card">
                            <div className="card-body">
                                <h3 className="card-title mb-2">Motion Details - <i>{name}</i></h3>
                                {
                                    status === 1 && !showOnlyResult ? <button className="btn btn-primary" onClick={this.stopPoll}>Stop Motion</button> : null
                                }
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-6 col-xl-6">
                        <div className="card-box bg-pattern">
                            <div className="row">
                                <div className="col-6">
                                    <div className="avatar-md bg-blue rounded">
                                        <i className="fe-users avatar-title font-22 text-white"/>
                                    </div>
                                </div>
                                <div className="col-6">
                                    <div className="text-right">
                                        <h3 className="text-dark my-1"><span
                                            data-plugin="counterup">{delegatesCount}</span></h3>
                                        <p className="text-muted mb-0 text-truncate">Total Delegates</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {
                            !showOnlyResult ?
                                <div className="card-box bg-pattern">
                                    <div className="row">
                                        <div className="col-6">
                                            <div className="avatar-md bg-success rounded">
                                                <i className="fe-user-check avatar-title font-22 text-white"/>
                                            </div>
                                        </div>
                                        <div className="col-6">
                                            <div className="text-right">
                                                <h3 className="text-dark my-1"><span
                                                    data-plugin="counterup">{delegatesOnline}</span></h3>
                                                <p className="text-muted mb-0 text-truncate">Delegates Online</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                : null
                        }
                        <div className="card-box bg-pattern">
                            <div className="row">
                                <div className="col-6">
                                    <div className="avatar-md bg-success rounded">
                                        <i className="fe-user-check avatar-title font-22 text-white"/>
                                    </div>
                                </div>
                                <div className="col-6">
                                    <div className="text-right">
                                        <h3 className="text-dark my-1"><span
                                            data-plugin="counterup">{votesCount}</span></h3>
                                        <p className="text-muted mb-0 text-truncate">Votes Count</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="card-box bg-pattern">
                            <div className="row">
                                <div className="col-6">
                                    <div className="avatar-md bg-success rounded">
                                        <i className="fe-user-check avatar-title font-22 text-white"/>
                                    </div>
                                </div>
                                <div className="col-6">
                                    <div className="text-right">
                                        <h3 className="text-dark my-1"><span
                                            data-plugin="counterup">{delegatesCount - votesCount}</span></h3>
                                        <p className="text-muted mb-0 text-truncate">Non-Voters</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div className="col-lg-6 col-xl-6">
                        <div className="card">
                            <div className="card-body" dir="ltr">
                                <h4 className="header-title mb-3">
                                    {status === 1 ? <i className="fe-bar-chart-2 text-success mr-2"/> : null}
                                    Motion Results
                                    {
                                        status === 1 ? '(Updating Live)' :
                                            status === 2 ? '(Motion Ended)' : null
                                    }
                                </h4>
                                {
                                    questions.map(question => {
                                        let maxVotesCount = 1;
                                        let options = question.options.map(option => {
                                            let progress = 0;
                                            let optionCount = 0;
                                            if(results.hasOwnProperty(option.id)){
                                                optionCount = results[option.id];
                                                progress = Math.round((optionCount * 100)/ votesCount);
                                                if(optionCount >= maxVotesCount){
                                                    maxVotesCount = optionCount;
                                                }
                                            }
                                            return {
                                                id: option.id,
                                                text: option.text,
                                                progress,
                                                optionCount
                                            }
                                        });
                                        return (
                                            <div key={question.id}>
                                                <p dangerouslySetInnerHTML={{ __html: question.text }} />
                                                <ul className="list-group poll-results">
                                                    {
                                                        options.map(option => {
                                                            let {
                                                                progress = 0,
                                                                optionCount = 0
                                                            } = option;
                                                            return (
                                                                <li key={option.id} className="list-group-item text-dark list-group-item-action d-flex justify-content-between align-items-center">
                                                                    <span className="progress" style={{width: progress+'%'}}/>
                                                                    <span>
                                                                        {
                                                                            optionCount === maxVotesCount ? <i className="fe-check mr-1"/> : <i className="fe-circle mr-1" />
                                                                        }
                                                                        {option.text}
                                                                    </span>
                                                                    <span>
                                                                        ({optionCount})
                                                                    </span>
                                                                </li>
                                                            );
                                                        })
                                                    }
                                                </ul>
                                            </div>
                                        );
                                    })
                                }
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div className="row">
                    {
                        !showOnlyResult && votersList && votersList.length ?
                            <div className="col-sm-6">
                                <div className="card">
                                    <div className="card-body">
                                        <h4 className="header-title mb-3">Users List</h4>
                                        <div className="inbox-widget" >
                                            <ul className="list-group">
                                                {
                                                    votersList.sort((a, b) => a.online_status - b.online_status).map(user => {
                                                        let online = parseInt(user.online_status);
                                                        return (
                                                            <li className="list-group-item">
                                                                <i className={`mdi mdi-checkbox-blank-circle ${online === 2 ? 'text-success' : online === 1 ? 'text-warning' : 'text-danger'} mr-2`}/>
                                                                {user.name}
                                                            </li>
                                                        );
                                                    })
                                                }
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            : null
                    }
                    {
                        nonVotersList && nonVotersList.length ?
                            <div className="col-sm-6">
                                <div className="card">
                                    <div className="card-body">
                                        <h4 className="header-title mb-3">Non-Voters List</h4>
                                        <div className="inbox-widget">
                                            <ul className="list-group">
                                                {
                                                    nonVotersList.map(user => {
                                                        return (
                                                            <li className="list-group-item">
                                                                {user.name} {user.last_name} ({user.member_id} - {user.email})
                                                            </li>
                                                        );
                                                    })
                                                }
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            : null
                    }
                </div>
            </>
        );
    }
}

export default PollResults;