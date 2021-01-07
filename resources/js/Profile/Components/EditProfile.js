import React, { Component } from "react";
import { WithContext as ReactTags } from 'react-tag-input';
import "./style.css"
import {ChipSet, Chip} from '@material/react-chips';

const {
    userId,
    profileUpdateURL,
    token,
    tagSuggestions,
} = window.config || {};

const interestsList = [
    "Networking",
    "Lead generation",
    "Business matchmaking",
    "Making contacts",
    "Selling",
    "Adding prospects",
    "Knowledge sharing/gaining",
    "Product info/demo",
    "Vendor meeting",
    "Other",
];

const inputRef = React.createRef();

class EditProfile extends Component{
    state = {
        saving: false,
        tags: [],
        suggestions:tagSuggestions.map(i => ({ id: i, text: i })),
    };

    componentDidMount() {
        const {
            name = '',
            last_name = '',
            bio = ' ',
            email = '',
            company_name = '',
            company_size = '',
            job_title = '',
            company_website_link = '',
            industry = '',
            facebook_link = '',
            twitter_link = '',
            linkedin_link = '',
            website_link = '',
            tags,
            looking_for_tags,
            profileImage = '',
            interests,
        } = this.props.user;
        this.setState({
            name,
            last_name,
            bio,
            email,
            company_name,
            job_title,
            company_website_link,
            facebook_link,
            twitter_link,
            linkedin_link,
            website_link,
            profileImage,
            industry,
            company_size,
            tags: (tags || []).map(t => t.tag),
            looking_for_tags: (looking_for_tags || []).map(t => t.tag),
            interests: (interests || []).map(t => t.interest),
        });
        window.initializeFileUploads();
        if(inputRef && inputRef.current){
            inputRef.current.addEventListener("uploaded", () => {
                this.setState({
                    profileImage: inputRef.current.value
                });
            });
        }
    }

    saveProfile = (e) => {
        this.setState({
            saving: true
        });
        e.preventDefault();
        let {
            suggestions,
            ...toSend
        } = this.state;
        $.ajax({
            url: profileUpdateURL,
            method: "POST",
            data: {
                _token: token,
                ...toSend,
            },
            success: (response) => {
                if(response && response.success){
                    showMessage("Profile Updated!", "success");
                    if(typeof this.props.onSave === "function"){
                        this.props.onSave();
                    }
                }else{
                    showMessage(response.message || "Some error occurred while saving!", "error");
                }
                this.setState({
                    saving: false
                });
            },
            error: () => {
                showMessage("Some error occurred while saving!", "error");
                this.setState({
                    saving: false
                });
            }
        });
    };

    handleChange = (e) => {
        if(e.target.name){
            this.setState({
                [e.target.name]: e.target.value
            });
        }
    };

    updateTagsSelection = (tagInput, value) => {
        this.setState({
            [tagInput]: value
        });
    };

    //Tags Input Related stuff
    handleDelete = (field) => (i) => {
        this.setState({
            [field]: this.state[field].filter((tag, index) => index !== i),
        });
    }

    handleAddition = (field) => (tag) => {
        this.setState(state => ({ [field]: [...state[field], tag] }));
    }

    handleDrag = (field) => (tag, currPos, newPos) => {
        const tags = [...this.state[field]];
        const newTags = tags.slice();

        newTags.splice(currPos, 1);
        newTags.splice(newPos, 0, tag);

        // re-render
        this.setState({ [field]: newTags });
    }
    //Tags Input Related stuff Ends Here

    render() {
        const {
            name = '',
            last_name = '',
            bio = ' ',
            email = '',
            company_name = '',
            company_size = '',
            company_website_link = '',
            job_title = '',
            facebook_link = '',
            twitter_link = '',
            linkedin_link = '',
            industry = '',
            website_link = '',
            saving = false,
            tags,
            looking_for_tags,
            interests,
            suggestions,
            profileImage,
        } = this.state;
        return <div className="card-box">
            <form>
                <h5 className="mb-4 text-uppercase"><i className="mdi mdi-account-circle mr-1"/> Personal Info</h5>
                <div className="row">
                    <div className="col-md-12">
                        <label htmlFor="">Profile Picture</label>
                        <div className="image-uploader profilepic">
                            <input type="hidden" id="profileurl" ref={inputRef} className="upload_input" name="profileImage" />
                            <input accept="images/*" type="file" data-name="imageurl" data-plugins="dropify" data-type="image" data-default-file={profileImage} />
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="firstname">First Name</label>
                            <input type="text" value={name} onChange={this.handleChange} id="firstname" className="form-control" name="name" placeholder="First Name"/>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="lastname">Last Name</label>
                            <input type="text" className="form-control" onChange={this.handleChange} value={last_name} name="last_name" id="lastname" placeholder="Enter last name"/>
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-12">
                        <div className="form-group">
                            <label htmlFor="userbio">Bio</label>
                            <textarea className="form-control" onChange={this.handleChange} value={bio} name="bio" id="userbio" rows="4"
                                      placeholder="Write something..."/>
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        <div className="form-group">
                            <label htmlFor="useremail">Email Address</label>
                            <input type="email" disabled={true} value={email} onChange={this.handleChange} className="form-control" id="useremail" placeholder="Enter email"/>
                        </div>
                    </div>
                </div>
                <h5 className="mb-3 text-uppercase bg-light p-2"><i className="mdi mdi-heart mr-1"/> Interests</h5>
                <div className="row">
                    <div className="col-md-12">
                        <div className="form-group">
                            <label>Select any 4 Technologies of interest</label>
                            <ChipSet
                                handleSelect={tags => this.updateTagsSelection("tags", tags)}
                                selectedChipIds={tags}
                                filter={true}
                            >
                                {suggestions.map((chip) =>
                                    <Chip
                                        id={chip.id}
                                        key={chip.id}
                                        label={chip.text}
                                    />
                                )}
                            </ChipSet>
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div className="form-group">
                            <label>Who I am looking for?</label>
                            <ChipSet
                                handleSelect={tags => this.updateTagsSelection("looking_for_tags", tags)}
                                selectedChipIds={looking_for_tags}
                                filter={true}
                            >
                                {suggestions.map((chip) =>
                                    <Chip
                                        id={chip.id}
                                        key={chip.id}
                                        label={chip.text}
                                    />
                                )}
                            </ChipSet>
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div className="form-group">
                            <label>Select key areas of interest</label>
                            <ChipSet
                                handleSelect={tags => this.updateTagsSelection("interests", tags)}
                                selectedChipIds={interests}
                                filter={true}
                            >
                                {interestsList.map((interest) =>
                                    <Chip
                                        id={interest}
                                        key={interest}
                                        label={interest}
                                    />
                                )}
                            </ChipSet>
                        </div>
                    </div>

                </div>
                <h5 className="mb-3 text-uppercase bg-light p-2"><i className="mdi mdi-office-building mr-1"/> Company Info</h5>
                <div className="row">
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="companyname">Company Name</label>
                            <input type="text" className="form-control" onChange={this.handleChange} id="companyname" name="company_name" value={company_name}
                                   placeholder="Enter company name"/>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="industry">Industry</label>
                            <select id="industry" className="form-control" value={industry} onChange={this.handleChange} name="industry">
                                <option value="">Choose industry</option>
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
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="cjob_title">Role</label>
                            <select id="cjob_title" className="form-control" value={job_title} onChange={this.handleChange} name="job_title">
                                <option value="">Your Role</option>
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
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="company_size">Company Size</label>
                            <select name="company_size" onChange={this.handleChange} value={company_size} id="company_size" className="form-control">
                                <option value="">Select Company Size</option>
                                <option value="0 - 100">0 - 100</option>
                                <option value="100 - 250">100 - 250</option>
                                <option value="250 - 500">250 - 500</option>
                                <option value="500  - 1000">500  - 1000</option>
                                <option value="1000+">1000+</option>
                            </select>
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div className="form-group">
                            <label htmlFor="cwebsite">Website</label>
                            <input type="text" className="form-control" onChange={this.handleChange} id="cwebsite" name="company_website_link" value={company_website_link} placeholder="Enter website url"/>
                        </div>
                    </div>
                </div>
                <h5 className="mb-3 text-uppercase bg-light p-2"><i className="mdi mdi-earth mr-1"/> Social</h5>
                <div className="row">
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="social-fb">Facebook</label>
                            <div className="input-group">
                                <div className="input-group-prepend">
                                    <span className="input-group-text"><i className="fab fa-facebook-square"/></span>
                                </div>
                                <input type="text" name="facebook_link" onChange={this.handleChange} value={facebook_link} className="form-control" id="social-fb" placeholder="Url"/>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="social-tw">Twitter</label>
                            <div className="input-group">
                                <div className="input-group-prepend">
                                    <span className="input-group-text"><i className="fab fa-twitter"/></span>
                                </div>
                                <input type="text" name="twitter_link"  onChange={this.handleChange} value={twitter_link} className="form-control" id="social-tw" placeholder="Username"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="social-lin">Linkedin</label>
                            <div className="input-group">
                                <div className="input-group-prepend">
                                    <span className="input-group-text"><i className="fab fa-linkedin"/></span>
                                </div>
                                <input type="text" className="form-control" name="linkedin_link"  onChange={this.handleChange} value={linkedin_link} id="social-lin" placeholder="Url"/>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="form-group">
                            <label htmlFor="social-insta">Website</label>
                            <div className="input-group">
                                <div className="input-group-prepend">
                                    <span className="input-group-text"><i className="fa fa-link"/></span>
                                </div>
                                <input type="text" value={website_link} name="website_link"  onChange={this.handleChange} className="form-control" id="social-insta" placeholder="Url"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="text-right">
                    <button disabled={saving} onClick={this.props.onSave} type="submit" className="btn text-danger mr-2 waves-effect waves-light mt-2"> Cancel
                    </button>
                    <button disabled={saving} onClick={this.saveProfile} type="submit" className="btn btn-success waves-effect waves-light mt-2"><i
                        className="mdi mdi-content-save"/> Save
                    </button>
                </div>
            </form>
        </div>;
    }
}

export default EditProfile;