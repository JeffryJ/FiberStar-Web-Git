import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class TimelineContent extends Component {
    constructor(props) {
      super(props);
    }

    render() {
        return (
            <div className="col-md-3">
                <div className="tim-box d-flex justify-content-center align-items-center flex-column">
                    <div className="tim-image"><img src={this.props.image}></img></div>
                    <div className="tim-date">{this.props.date}</div>
                    <div className="tim-desc">{this.props.content}</div>
                </div>
            </div>
        )
    }

    // render() {
    //     return (
    //       <div className="the-timeline-rhombus-fill">
    //         <div className="the-timeline-rhombus"></div>
    //         <div className="the-timeline-content">
    //           <div className="the-timeline-content-img">
    //             <img src={this.props.image} alt=""/>
    //           </div>
    //           <div className="the-timeline-content-desc">
    //             <div className="the-timeline-content-year">
    //                {this.props.time}
    //             </div>
    //             <div className="the-timeline-content-words">
    //               {this.props.content}
    //             </div>
    //           </div>
    //         </div>
    //       </div>
    //     );
    // }
}
