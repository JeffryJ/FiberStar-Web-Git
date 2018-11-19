import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Starimg extends Component {
    constructor(){
      super();
      this.state ={
            imagestar: "",
            // boxtwo:"As a company dedicated and committed to provide reliable and quality services for customer. FiberStar holds to the highest corporate values in all of the operations, with: "
          // imagestar: null,
            boxtwo: ""
      };

    }

    componentWillMount() {
        fetch('api/about-us-page')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        imagestar: data.imagestar,
                        boxtwo: data.boxtwo
                    }
                );
            });

    }

    componentDidUpdate(){
        window.sr.reveal('.star-img', {
            duration: 2000,
            origin:'bottom',
            distance:'200px',
        });
    }

    render() {
        if(this.state.imagestar !==""){
            return (
                <div className="star-wrapper">
                    <div className="container">
                        <div className="star-box-one">Corporate Values</div>
                        <div className="star-box-two">{this.state.boxtwo}</div>
                        <div className="star-img" style={{backgroundColor:"LightGrey",backgroundImage: "url(/"+this.state.imagestar+")"}}></div>
                    </div>
                </div>

            );
        }
        else{
            return(
                <div className="star-img">
                    <div className="loading-container-black">
                        <i className="fas fa-spinner fa-spin" style={{fontSize:"30px",verticalAlign:"middle"}}></i>
                    </div>
                </div>
            );
        }
    }
}
