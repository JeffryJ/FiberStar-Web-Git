import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Slider from "react-slick";


export default class OurSlider extends Component {
    constructor(){
      super();

      this.state = {
        ImgSlides: null
      }
    }

    componentDidMount() {
        fetch('api/our-team-slider')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        ImgSlides:data.ImgSlides
                    }
                );
            });
    }

    renderSlide(){
      if(this.state.ImgSlides != null) {
          return this.state.ImgSlides.map((item, i) =>
              <div className="activity-slide-wrapper" key={'slide' + i}>
                  <img src={item} alt=""/>
              </div>
          );
      }
    }

    render() {
      var settings = {
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 4000,
        pauseOnHover:false,
      };

        return (
          <div className="our-slide-wrapper">
            <Slider {...settings}>
            {this.renderSlide()}
                         
            </Slider>
          </div>
        );
    }
}
