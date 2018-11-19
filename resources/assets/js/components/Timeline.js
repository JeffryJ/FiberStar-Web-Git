import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Slider from "react-slick";
import TimelineContent from './TimelineContent';

export default class Timeline extends Component {
    constructor(props) {
      super(props);

        this.state = {
            // timeline:[
            //     {
            //         year:"2016",
            //         info:[
            //             {image:"+",date:"Febuary 2016",content:"lorem ipsum heheh"},
            //             {image:"+",date:"July 2016",content:"lorem ipsum heheh"},
            //             {image:"+",date:"July 2016",content:"lorem ipsum heheh"},
            //             {image:"+",date:"July 2016",content:"lorem ipsum heheh"},
            //
            //
            //         ],
            //     },
            //     {
            //         year:"2017",
            //         info:[
            //             {image:"+",date:"Febuary 2017",content:"lorem ipsum heheh"},
            //             {image:"+",date:"July 2017",content:"lorem ipsum heheh"},
            //         ],
            //     },
            //     {
            //         year:"2018",
            //         info:[
            //             {image:"+",date:"Febuary 2018",content:"lorem ipsum heheh"},
            //             {image:"+",date:"July 2018",content:"lorem ipsum heheh"},
            //             {image:"+",date:"July 2018",content:"lorem ipsum heheh"},
            //         ],
            //     }
            // ],
            timeline:[],
            currentslide:0,
        }

    }

    renderMileYear(){
        var thetime = this.state.timeline;
        var content =[];

        for( var i in thetime ){
            content.push(
                <div key={i}>{thetime[i].year}</div>
            );
        }

        return content;
    }

    componentWillMount() {
        fetch('api/milestones')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        timeline:data.timeline,
                        currentslide: data.timeline.length-1
                    }
                );
            });
    }
    // renderContent() {
    //     if(this.state.timeline!=null) {
    //         var content = [];
    //         for (var i = 0; i < this.state.timeline.length / 3; i++) {
    //             content.push(
    //                 <div className="the-timeline" key={i}>
    //                     <div className="the-timeline-rhombus-wrapper d-flex justify-content-center">
    //                         {this.state.timeline.slice(i * 3, (i + 1) * 3).map((item, i) =>
    //                             <TimelineContent time={item.time} image={item.image} content={item.content}
    //                                              key={'item' + i}/>
    //                         )}
    //                     </div>
    //                 </div>
    //             );
    //         }
    //         return content;
    //     }
    //     else{
    //         return(
    //             <div className="loading-container-black">
    //                 <i className="fas fa-spinner fa-spin" style={{fontSize:"30px",verticalAlign:"middle"}}></i>
    //             </div>
    //         );
    //     }
    // }

    // render() {
    //     return (
    //       <div className="fiberstar-timeline-wrapper">
    //         <div className="container">
    //           <div className="col-md-12">
    //             <div className="the-timeline-title mx-auto">
    //               MILESTONE
    //             </div>
    //             {this.renderContent()}
    //           </div>
    //         </div>
    //       </div>
    //     );
    // }

    render() {
        if(this.state.timeline.length > 0) {
            var settings = {
                arrows:true,
                infinite:false,
                centerMode: true,
                slidesToShow: 3,
                initialSlide:this.state.timeline.length-1,
                afterChange: current => this.setState({ currentslide:current})
            };
            return (
                <div className="tim-nav">
                    <div className="tim-title fbas mx-auto">MILESTONE</div>
                    <div className="tim-slide mx-auto">
                        <Slider {...settings}>
                            {this.renderMileYear()}
                            <div></div>
                            <div></div>
                        </Slider>


                    </div>
                    <div className="container tim-box-wrapper">
                        <div className="row justify-content-md-center">
                            {
                                this.state.timeline[this.state.currentslide].info.map((item, i) =>
                                    <TimelineContent image={item.image} date={item.date} content={item.content}
                                                     key={i}/>
                                )
                            }
                        </div>
                    </div>
                </div>

            );
        }
        else{
            return (
                <div className="loading-container-black">
                    <i className="fas fa-spinner fa-spin" style={{fontSize:"30px",verticalAlign:"middle"}}></i>
                </div>
            );
        }
    }

}
