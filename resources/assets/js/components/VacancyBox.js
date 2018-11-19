import React, { Component } from 'react';
import ReactDOM from 'react-dom';



export default class OurTeam extends Component {
    constructor(props){
      super(props);
    }

    render() {


        return (
                  <div className="vacancy-box">
                  <a href={location.protocol + '//' + location.host + '/job/' + this.props.id}>
                  <div className="vacancy-img">
                      <img src={this.props.image} alt=""/>
                   </div>
                    <div className="vacancy-desc">
                        <p>{this.props.jobdesc}</p>
                    </div>
                  </a>
                  </div> 
                
        );
    }
}
