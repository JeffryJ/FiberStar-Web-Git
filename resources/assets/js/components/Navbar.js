import React, { Component } from 'react';
import ReactDOM from 'react-dom';

const imglogo= "/storage/assets/fiberlogowhite.png";

export default class Navbar extends Component {
    constructor(props){
      super(props);

        this.state = {
            company_logo:""
        };
    }

    componentWillMount(){
        fetch('/api/main-data')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        company_logo:'/'+data.logo_image_link
                    }
                );
            });
    }

    render() {
        return (
            <div className="navbar-wrapper-outer">
                <div className="navbar-wrapper">
                    <ul className="">
                        <li><a href={location.protocol + '//' + location.host + '/about'}>About</a></li>
                        <li><a href={location.protocol + '//' + location.host + '/services'}>Services</a></li>
                        <li><a href={location.protocol + '//' + location.host + '/coverage'}>Coverage</a></li>
                        <li><a href={location.protocol + '//' + location.host + '/home'}><img src={this.state.company_logo} alt=""/></a></li>
                        <li><a href={location.protocol + '//' + location.host + '/news'}>News</a></li>
                        <li><a href={location.protocol + '//' + location.host + '/team'}>Our Team</a></li>
                        <li> <a href="#" id="contact-us">Contact Us</a> </li>
                    </ul>
                </div>

                <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                    <a className ="navbar-brand" href="/home"><img src={imglogo} height="50px" alt="" /></a>
                    <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul className="navbar-nav">
                            <li className="nav-item ">
                                <a className="nav-link" href={location.protocol + '//' + location.host + '/about'}>About</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href={location.protocol + '//' + location.host + '/services'}>Services</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href={location.protocol + '//' + location.host + '/coverage'}>Coverages</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href={location.protocol + '//' + location.host + '/news'}>News</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href={location.protocol + '//' + location.host + '/team'}>Our Team</a>
                            </li>
                            <li className="nav-item">
                                <a className="nav-link" href="#" id="contact-us">Contact us</a>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
      );
    }
}

if (document.getElementById('nav-bar')) {
    ReactDOM.render(<Navbar />, document.getElementById('nav-bar'));
}
