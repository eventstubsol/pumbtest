import React, { Component, useEffect } from "react";
import ReactDOM from "react-dom";
import ProfileInfo from "./ProfileInfo";

const {
    connectionRequestsURL,
    token,
    fetchUserDetails,
} = window.config;

class Invitations extends Component{
    state = {
        loading: false,
        initialLoad: false,
        users: [],
        page: 1,
        total_pages: 0,
        per_page: 0,
        total: 0,
        offset: 0,
        showingProfile: false,
        lastRequestTime: 0,
    };

    componentDidMount() {
        this.fetchRequests();
        window.listenForChanges("lastRequestTime", (lastRequestTime) => {
            if(lastRequestTime !== this.state.lastRequestTime){
                this.fetchRequests(this.state.page, true);
                this.setState({
                    lastRequestTime
                });
            }
        });
        window.showProfile = (userId) => {
            this.showProfile(userId)();
        }
    }

    openPage = (page) => (e) => {
        e.preventDefault();
        if(page >= 1 && page <= this.state.total_pages){
            this.fetchRequests(page);
        }
    };

    fetchRequests = (page = 1, isRefresh = false) => {
        if(!isRefresh){
            this.setState({
                loading: true,
            });
        }
        $.ajax({
            url: connectionRequestsURL,
            method: "POST",
            data: {
                _token: token,
                page,
            },
            success: (response) => {
                if(response && Array.isArray(response.users)){
                    this.setState({
                        ...response,
                    });
                }
                this.setState({
                    loading: false,
                    initialLoad: true
                });
            },
            error: (err) => {
                console.log(err)
                this.setState({
                    loading: false,
                    initialLoad: true
                });
            }
        })
    }

    showProfile = (showingProfile) => (e = false) => {
        e && typeof e.preventDefault === "function" && e.preventDefault();
        if(typeof showingProfile === "string"){
            //Fetch user and then show
            let loader = $(".loader");
            loader.show();
            $.ajax({
                url: fetchUserDetails,
                method: "POST",
                data: {
                    user: showingProfile,
                    _token: token,
                },
                success: (data) => {
                    if(data && data.success && data.user){
                        this.setState({
                            showingProfile: data.user,
                        })
                    }else{
                        window.showMessage("Could not find the profile!", "error");
                    }
                    loader.hide();
                },
                error: () => {
                    window.showMessage("Some error occurred while fetching profile! Please try again in some time.", "error");
                    loader.hide();
                }
            })
        }else{
            this.setState({
                showingProfile
            });
        }
    };

    hideUser = () => {
        this.setState({
            showingProfile: false
        });
    };

    handleUpdate = (id, updates) => {
        this.setState({
            showingProfile: {
                ...this.state.showingProfile,
                ...updates,
            }
        });
        this.fetchRequests();
    };

    render(){
        const {
            loading,
            initialLoad,
            users,
            page,
            total_pages,
            total,
            per_page,
            showingProfile,
            offset,
        } = this.state;
        return <div className="card-box">
            <h4 className="header-title mb-3">Invitations</h4>
            <div className="inbox-widget">
                {
                    users && users.length ? users.map((user, index) => (
                        <div className="inbox-item" key={index}>
                            <div className="inbox-item-img">
                                <img src={user.profileImage} className="rounded-circle" alt=""/>
                            </div>
                            <p className="inbox-item-author">{user.name}</p>
                            <p className="inbox-item-text">{user.bio}</p>
                            <p className="inbox-item-date">
                                <a href="" className="btn btn-sm btn-link text-info font-13" onClick={this.showProfile(user)}> View Profile</a>
                            </p>
                        </div>
                    )) :
                        !loading ? <p>All caught up!</p> : null
                }
                {
                    loading ? <div className={"hfp-loader"}><span className="spinner" /></div> : null
                }
                {
                    initialLoad && users && users.length ? <div>
                        <ul className="pagination pagination-rounded justify-content-center mt-2">
                            <li className="page-item" onClick={this.openPage(page - 1)}>
                                <button disabled={page === 1} className="page-link" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span className="sr-only">Previous</span>
                                </button>
                            </li>
                            {
                                new Array(total_pages).fill(0).map((c,i) => <li key={"li"+i} className={"page-item "+((i + 1) === page ? "active" : "")}><a className="page-link" onClick={this.openPage(i + 1)}>{i + 1}</a></li>)
                            }
                            <li className="page-item">
                                <button disabled={page === total_pages} className="page-link" aria-label="Next" onClick={this.openPage(page + 1)}>
                                    <span aria-hidden="true">»</span>
                                    <span className="sr-only">Next</span>
                                </button>
                            </li>
                        </ul>
                        <p className={"text-center"}>Showing {offset + 1} - {offset + Math.min(users.length,per_page)} of {total}</p>
                    </div> : null
                }
            </div>
            {
                showingProfile ? <ShowUserProfile updateStatus={this.handleUpdate} hideUser={this.hideUser} user={showingProfile} /> : null
            }
        </div>;
    }
}

const ShowUserProfile = (props) => {
    let modalEl = $("#view-profile-modal");
    modalEl.modal("show");
    modalEl.on("hidden.bs.modal", () => {
        if(typeof props.hideUser === "function"){
            props.hideUser();
        }
    });
    return ReactDOM.createPortal(
        <ProfileInfo {...props} />,
        document.querySelector("#profile-detail-view")
    );
};

export default Invitations;