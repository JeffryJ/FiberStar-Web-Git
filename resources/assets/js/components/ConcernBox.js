import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class ConcernBox extends Component {
  constructor(props) {
    super(props);
  }

    render() {
        return (
          <div className="concern-box">
            <div className="row">
              <div className="col-5">
                <div className="concern-num">{this.props.number}</div>
              </div>
              <div className="col-7">
                <div className="concern-desc">
                  {this.props.mconcern}
                </div>
              </div>
            </div>
          </div>

        );
    }
}
