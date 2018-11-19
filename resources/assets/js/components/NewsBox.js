import React, { Component } from 'react';
import ReactDOM from 'react-dom';


export default class NewsBox extends Component {
    constructor(props){
      super(props);
    }

    render() {
        return (
          <div className="col-md-6">
            <div className="news-box">
                <a  href={location.protocol + '//' + location.host + '/news/' + this.props.newsid}>
                  <div className="row">
                    <div className="col-4">
                      <div className="news-box-pic"> <img src={this.props.image} alt=""/> </div>
                    </div>
                    <div className="col-8">
                      <div className="news-box-desc-wrapper">
                        <div className="news-box-date">{this.props.date}</div>
                        <div className="news-box-title">{this.props.title}</div>
                        <div className="news-box-desc">{this.props.newsdesc}</div>
                      </div>
                    </div>
                  </div>
                </a>
            </div>
          </div>

        );
    }
}
