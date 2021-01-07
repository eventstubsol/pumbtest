import React, { Component } from "react";
import ProfileInfo from "./ProfileInfo";

const {
    userId,
    profileUpdateURL,
    token,
    suggestedContactsURL,
    attendeesURL,
    savedContactsURL,
    tagSuggestions,
    exportContactsURL,
    mailContactsURL,
} = window.config || {};

const recordEvent = window.recordEvent;

const requestsHelper = (url, args = {}) => {
    return new Promise(resolve => {
        $.ajax({
            url: url,
            method: "POST",
            data: {
                ...args,
                _token: token,
            },
            success: suggestions => {
                if(suggestions && suggestions.users && Array.isArray(suggestions.users)){
                    resolve(suggestions);
                }else{
                    resolve([]);
                }
            },
            error: err => {
                console.log(err);
                resolve([]);
            }
        });
    });

}

class Contacts extends Component{
    state = {
        loadingSuggestions: false,
        suggestions: [],
    };

    render() {
        return <div className="">
            <ul className="nav nav-pills navtab-bg nav-justified" style={{margin: '0 -5px'}}>
                <li className="nav-item">
                    <a href="#suggestions" data-toggle="tab" aria-expanded="true" className="nav-link active">
                        Suggested
                    </a>
                </li>
                <li className="nav-item">
                    <a href="#attendees" data-toggle="tab" aria-expanded="false" className="nav-link">
                        All Attendees
                    </a>
                </li>
                <li className="nav-item">
                    <a href="#my-contacts" data-toggle="tab" aria-expanded="false" className="nav-link">
                        My Contacts
                    </a>
                </li>
            </ul>
            <div className="tab-content">
                <div className="tab-pane show active" id="suggestions">
                    <AttendeeList showSearch={false} editProfile={this.props.editProfile} url={suggestedContactsURL} />
                </div>
                <div className="tab-pane" id="attendees">
                    <AttendeeList url={attendeesURL} />
                </div>
                <div className="tab-pane" id="my-contacts">
                    <AttendeeList allowExport={true} url={savedContactsURL} showOnlyContacts={true} />
                </div>
            </div>
        </div>;
    }
}


class AttendeeList extends Component{
    _mounted = false;
    state = {
        loading: false,
        initialLoad: false,
        users: [],
        page: 1,
        total_pages: 0,
        per_page: 0,
        total: 0,
        lastRequestTime: 0,
        lastSentRequestTime: 0,
        //For Search & Filter
        tagSelected: "",
        search: "",
        industry: "",
        company_size: "",
        role: "",
    };

    handleTagSelect = (e, input = "tagSelected") => {
        if(e && e.target){
            recordEvent("contacts_filtered_"+input,"Filter Used / "+input, "attendees_interaction");
            this.setState({
                [input]: e.target.value,
            }, () => this.fetchAttendeesList(1));
        }
    };

    handleSearch = (e) => {
        if(e && e.target){
            recordEvent("contacts_filtered_search","Filter Used / Search", "attendees_interaction");
            this.setState({
                search: e.target.value,
            });
        }
    };
    handleSearchKeydown = (e) => {
        if(e && (e.which === 13 || e.keyCode === 13)){
            e.preventDefault();
            this.fetchAttendeesList(1);
        }
    };

    fetchAttendeesList = (page = 1, isRefresh = false) => {
        if(!this._mounted){ console.log("Not fetching since component is not mounted"); return false; }
        const {
            search,
            tagSelected,
            role,
            company_size,
            industry,
        } = this.state;
        if(!isRefresh){
            this.setState({
                loading: true,
                users: [],
                page,
            });
        }

        let q = {
            page
        };
        if(tagSelected !== ""){
            q.tag = tagSelected;
        }
        if(role !== ""){
            q.role = role;
        }
        if(company_size !== ""){
            q.company_size = company_size;
        }
        if(industry !== ""){
            q.industry = industry;
        }
        if(search && search.trim().length >= 1){
            q.search = search.trim();
        }
        requestsHelper(this.props.url, q).then(suggestions => {
            this.setState({
                ...suggestions,
                loading: false,
                initialLoad: true,
            });
        });
    };

    exportToCSV(){
        requestsHelper(exportContactsURL).then(response => {
            let rows = response.users;
            if(rows.length){
                let keys = {};
                Object.keys(rows[0]).map(k => keys[k] = k);
                rows = [
                    keys,
                    ...rows
                ];
                let csvContent = "data:text/csv;charset=utf-8,"
                    + rows.map(e => Object.values(e).join(",")).join("\n");
                var encodedUri = encodeURI(csvContent);
                let opener = document.createElement("a");
                opener.href = encodedUri;
                opener.download = "Event Contacts Export.csv";
                opener.click()
            }else{
                alert("Nothing to export!");
            }
        });
    }

    sendOnEmail(){
        requestsHelper(mailContactsURL).then(suggestions => {
            window.Swal.fire("Mail Sent", "", "success");
        });
    }

    componentDidMount() {
        this._mounted = true;
        this.fetchAttendeesList(1);
        window.listenForChanges(["lastRequestTime", "lastSentRequestTime", "contacts_count"], (updateTime, timeFor) => {
            if(updateTime !== this.state[timeFor]){
                if(this._mounted){
                    this.fetchAttendeesList(this.state.page, true);
                    this.setState({
                        [timeFor]: updateTime
                    });
                }
            }
        });
        window.addEventListener("hashchange", this.handleHashChange)
    }
    handleHashChange = (e) => {
        if(window.location.hash === "#attendees"){
            this.fetchAttendeesList(this.state.page, true);
        }
    };

    componentWillUnmount() {
        this._mounted = false;
        window.removeEventListener("hashchange", this.handleHashChange)
    }

    openPage = (page) => (e) => {
        e.preventDefault();
        if(page >= 1 && page <= this.state.total_pages){
            this.fetchAttendeesList(page);
        }
    };

    updateConnectionStatus = (id, status) => {
        let { users } = this.state;
        let found = false;
        users = users.map(user => {
            if(user.id === id){
                found = true;
                return {
                    ...user,
                    ...status,
                };
            }
            return user;
        });
        if(found && this._mounted){
            this.setState({
                users
            });
            if(this.props.showOnlyContacts){
                this.fetchAttendeesList(this.state.page - (users.filter(user => user.is_contact).length === 0 ? 1 : 0));
            }else{
                this.fetchAttendeesList(this.state.page, true);
            }
        }
    };

    handleCustomPageChange = (e) => {
        this.setState({
            customPage: e.target.value
        })
    }

    render(){
        let {
            loading,
            initialLoad,
            users,
            page,
            total_pages,
            total,
            per_page,
            tagSelected,
            search,
            industry,
            company_size,
            role,
            customPage = "",
        } = this.state;
        const {
            showSearch = true
        } = this.props;
        const offset = per_page * (page - 1);
        let toShow = 5;
        let startFrom = 1;
        if(page - 2 >= 1){
            startFrom = page - 2;
        }
        let pagesToShow = [];
        let endPage = startFrom + toShow;
        if(endPage > total_pages){
            endPage = total_pages;
        }
        for(let i = startFrom || 1; i < endPage; i++){
            pagesToShow.push(i);
        }
        return <>
            {
                showSearch ?
                    <div className="row">
                        <div className="col-12">
                            <div className="card-box">
                                <div className="row">
                                    <div className="col-md-12 mb-3 mb-lg-0">
                                        <label htmlFor="">Filter Results</label>
                                    </div>
                                    <div className="col-lg-6 mb-2">
                                        <div className="form-group m-0">
                                            <select className="custom-select" onChange={e => this.handleTagSelect(e, "industry")} value={industry}>
                                                <option value="">Industry</option>
                                                <option value="Government">Government</option>
                                                <option value="BFSI">BFSI</option>
                                                <option value="Oil & Gas">Oil & Gas</option>
                                                <option value="Retail">Retail</option>
                                                <option value="Transport & Logistics">Transport & Logistics</option>
                                                <option value="Education">Education</option>
                                                <option value="Healthcare">Healthcare</option>
                                                <option value="Aviation">Aviation</option>
                                                <option value="FMCG">FMCG</option>
                                                <option value="Power and Utilities">Power and Utilities</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div className="col-lg-6">
                                        <div className="form-group mb-3 mb-lg-0">
                                            <select className="custom-select" onChange={e => this.handleTagSelect(e, "company_size")} value={company_size}>
                                                <option value="">Company Size</option>
                                                <option value="0 - 100">0 - 100</option>
                                                <option value="100 - 250">100 - 250</option>
                                                <option value="250 - 500">250 - 500</option>
                                                <option value="500  - 1000">500  - 1000</option>
                                                <option value="1000+">1000+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div className="col-lg-6 mb-2">
                                        <div className="form-group m-0">
                                            <select className="custom-select" onChange={e => this.handleTagSelect(e, "role")} value={role}>
                                                <option value="">Role</option>
                                                <option value="CIO">CIO</option>
                                                <option value="CXO">CXO</option>
                                                <option value="Board Member">Board Member</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Influencer">Influencer</option>
                                                <option value="Decision Maker">Decision Maker </option>
                                                <option value="Finance controler">Finance controler</option>
                                                <option value="Entry-level">Entry-level</option>
                                                <option value="Research Professional">Research Professional</option>
                                                <option value="Vendor">Vendor</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div className="col-lg-6 mb-2">
                                        <div className="form-group m-0">
                                            <select className="custom-select" onChange={this.handleTagSelect} value={tagSelected}>
                                                <option value="">Interest</option>
                                                {
                                                    tagSuggestions.map(tag => <option key={tag} value={tag}>{tag}</option>)
                                                }
                                            </select>
                                        </div>
                                    </div>
                                    <div className="col-lg-9">
                                        <div className="form-group  m-0">
                                            <input type="search" value={search} onKeyDown={this.handleSearchKeydown} className="form-control" onChange={this.handleSearch} placeholder="Search..." />
                                        </div>
                                    </div>
                                    <div className="col-lg-3 ">
                                        <button disabled={loading} onClick={() => this.fetchAttendeesList(1)} className="btn-block btn btn-primary">
                                            <i className="fa fa-search" />
                                        </button>
                                    </div>
                                    {
                                        this.props.allowExport ?
                                            <div className="col-lg-12 text-right">
                                                <button disabled={loading} onClick={() => this.fetchAttendeesList(page)} className="mt-3 mr-2 btn btn-primary">
                                                    <i className="fa fa-refresh" /> Refresh
                                                </button>
                                                <button disabled={loading} onClick={this.exportToCSV} className="mt-3 mr-2 btn btn-primary">
                                                    <i className="fa fa-file-excel" /> Export to CSV
                                                </button>
                                                <button disabled={loading} onClick={this.sendOnEmail} className="mt-3 btn btn-primary">
                                                    <i className="fa fa-mail-bulk" /> Send on Email
                                                </button>
                                            </div> : null
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                    : null
            }
            <div className="row">
                {
                    users ? users.map((user, index) => <div key={"user-"+index} className="col-md-6"><ProfileInfo updateStatus={this.updateConnectionStatus} user={user} key={"suggestion-"+index} /></div>) : null
                }
            </div>
            {
                loading ? <div className={"hfp-loader"}><span className="spinner" /></div> : null
            }
            {
                initialLoad && users.length ?
                    <div>
                    <ul className="pagination pagination-rounded justify-content-center mt-2">
                        <li className="page-item" onClick={this.openPage(page - 1)}>
                            <button disabled={page === 1 || loading} className="page-link" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                                <span className="sr-only">Previous</span>
                            </button>
                        </li>
                        {
                            pagesToShow.map((c,i) => <li key={i} className={"page-item "+((c) === page ? "active" : "")}><button disabled={loading} className="page-link" onClick={this.openPage(c)}>{c}</button></li>)
                        }
                        <li className="page-item">
                            <button disabled={page === total_pages || loading} className="page-link" aria-label="Next" onClick={this.openPage(page + 1)}>
                                <span aria-hidden="true">»</span>
                                <span className="sr-only">Next</span>
                            </button>
                        </li>
                    </ul>
                    <p className="d-flex  align-items-center justify-content-center">
                        Page
                        <input type="number" min={1} max={total_pages} step={1} value={customPage} onChange={this.handleCustomPageChange} className={"form-control mx-3"} style={{maxWidth:"80px"}} />
                        <button className="btn  btn-md btn-primary" onClick={this.openPage(parseInt(customPage))}>Go</button>
                    </p>
                    <p className={"text-center"}>Showing {offset + 1} - {offset + Math.min(users.length,per_page)} of {total}</p>
                </div> :
                    typeof this.props.editProfile === "function" && !loading ?
                    <div className="card">
                    <div className="card-body p-4">

                        <div className="error-ghost text-center">
                            <svg className="ghost" width="127.433px" height="132.743px" viewBox="0 0 127.433 132.743">
                                        <path fill="#f79fac" d="M116.223,125.064c1.032-1.183,1.323-2.73,1.391-3.747V54.76c0,0-4.625-34.875-36.125-44.375
                                        s-66,6.625-72.125,44l-0.781,63.219c0.062,4.197,1.105,6.177,1.808,7.006c1.94,1.811,5.408,3.465,10.099-0.6
                                        c7.5-6.5,8.375-10,12.75-6.875s5.875,9.75,13.625,9.25s12.75-9,13.75-9.625s4.375-1.875,7,1.25s5.375,8.25,12.875,7.875
                                        s12.625-8.375,12.625-8.375s2.25-3.875,7.25,0.375s7.625,9.75,14.375,8.125C114.739,126.01,115.412,125.902,116.223,125.064z"></path>
                                <circle fill="#013E51" cx="86.238" cy="57.885" r="6.667"></circle>
                                <circle fill="#013E51" cx="40.072" cy="57.885" r="6.667"></circle>
                                <path fill="#013E51" d="M71.916,62.782c0.05-1.108-0.809-2.046-1.917-2.095c-0.673-0.03-1.28,0.279-1.667,0.771
                                        c-0.758,0.766-2.483,2.235-4.696,2.358c-1.696,0.094-3.438-0.625-5.191-2.137c-0.003-0.003-0.007-0.006-0.011-0.009l0.002,0.005
                                        c-0.332-0.294-0.757-0.488-1.235-0.509c-1.108-0.049-2.046,0.809-2.095,1.917c-0.032,0.724,0.327,1.37,0.887,1.749
                                        c-0.001,0-0.002-0.001-0.003-0.001c2.221,1.871,4.536,2.88,6.912,2.986c0.333,0.014,0.67,0.012,1.007-0.01
                                        c3.163-0.191,5.572-1.942,6.888-3.166l0.452-0.453c0.021-0.019,0.04-0.041,0.06-0.061l0.034-0.034
                                        c-0.007,0.007-0.015,0.014-0.021,0.02C71.666,63.771,71.892,63.307,71.916,62.782z"></path>
                                <circle fill="#FCEFED" stroke="#FEEBE6" strokeMiterlimit="10" cx="18.614" cy="99.426" r="3.292"></circle>
                                <circle fill="#FCEFED" stroke="#FEEBE6" strokeMiterlimit="10" cx="95.364" cy="28.676" r="3.291"></circle>
                                <circle fill="#FCEFED" stroke="#FEEBE6" strokeMiterlimit="10" cx="24.739" cy="93.551" r="2.667"></circle>
                                <circle fill="#FCEFED" stroke="#FEEBE6" strokeMiterlimit="10" cx="101.489" cy="33.051" r="2.666"></circle>
                                <circle fill="#FCEFED" stroke="#FEEBE6" strokeMiterlimit="10" cx="18.738" cy="87.717" r="2.833"></circle>
                                <path fill="#FCEFED" stroke="#FEEBE6" strokeMiterlimit="10" d="M116.279,55.814c-0.021-0.286-2.323-28.744-30.221-41.012
                                        c-7.806-3.433-15.777-5.173-23.691-5.173c-16.889,0-30.283,7.783-37.187,15.067c-9.229,9.736-13.84,26.712-14.191,30.259
                                        l-0.748,62.332c0.149,2.133,1.389,6.167,5.019,6.167c1.891,0,4.074-1.083,6.672-3.311c4.96-4.251,7.424-6.295,9.226-6.295
                                        c1.339,0,2.712,1.213,5.102,3.762c4.121,4.396,7.461,6.355,10.833,6.355c2.713,0,5.311-1.296,7.942-3.962
                                        c3.104-3.145,5.701-5.239,8.285-5.239c2.116,0,4.441,1.421,7.317,4.473c2.638,2.8,5.674,4.219,9.022,4.219
                                        c4.835,0,8.991-2.959,11.27-5.728l0.086-0.104c1.809-2.2,3.237-3.938,5.312-3.938c2.208,0,5.271,1.942,9.359,5.936
                                        c0.54,0.743,3.552,4.674,6.86,4.674c1.37,0,2.559-0.65,3.531-1.932l0.203-0.268L116.279,55.814z M114.281,121.405
                                        c-0.526,0.599-1.096,0.891-1.734,0.891c-2.053,0-4.51-2.82-5.283-3.907l-0.116-0.136c-4.638-4.541-7.975-6.566-10.82-6.566
                                        c-3.021,0-4.884,2.267-6.857,4.667l-0.086,0.104c-1.896,2.307-5.582,4.999-9.725,4.999c-2.775,0-5.322-1.208-7.567-3.59
                                        c-3.325-3.528-6.03-5.102-8.772-5.102c-3.278,0-6.251,2.332-9.708,5.835c-2.236,2.265-4.368,3.366-6.518,3.366
                                        c-2.772,0-5.664-1.765-9.374-5.723c-2.488-2.654-4.29-4.395-6.561-4.395c-2.515,0-5.045,2.077-10.527,6.777
                                        c-2.727,2.337-4.426,2.828-5.37,2.828c-2.662,0-3.017-4.225-3.021-4.225l0.745-62.163c0.332-3.321,4.767-19.625,13.647-28.995
                                        c3.893-4.106,10.387-8.632,18.602-11.504c-0.458,0.503-0.744,1.165-0.744,1.898c0,1.565,1.269,2.833,2.833,2.833
                                        c1.564,0,2.833-1.269,2.833-2.833c0-1.355-0.954-2.485-2.226-2.764c4.419-1.285,9.269-2.074,14.437-2.074
                                        c7.636,0,15.336,1.684,22.887,5.004c26.766,11.771,29.011,39.047,29.027,39.251V121.405z"></path>
                                    </svg>
                        </div>

                        <div className="text-center">
                            <h3 className="mt-4">No Suggestions found! </h3>
                            <p className="text-muted">Looks we don't have enough details on you to suggest people.</p>
                            <p className="text-muted">Adds some tags to your profile so that we can suggest you a bunch of people you would like to meet here.</p>
                            <p className="mb-2">
                                <button onClick={this.props.editProfile} className="btn btn-primary">Edit Profile</button>
                            </p>
                        </div>

                    </div>
                </div> : null
            }
        </>;
    }
}


export default Contacts;