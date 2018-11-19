import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import request from 'superagent';
import Slider from "react-slick";
const api = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=3032721881.1677ed0.3df8d910e23d44dd8782136ff4e9eaf2'

export default class InstaSlider extends Component {
    constructor(props){
      super(props);
      this.state = {
          photos:[]
      }
    this.fetchPhotos = this.fetchPhotos.bind(this);
    }

    fetchPhotos(){
      request
      .get(api)
      .then((res) => {
        this.setState({
          photos: res.body.data.slice(0,10)
        })
      })
    }

    componentWillMount(){
      this.fetchPhotos();
    }

    renderPhotos(){
      return this.state.photos.map((item, i)=>
        <div key={'insta'+i}>
          <a href={item.link}>
            <img src={item.images.thumbnail.url} alt=""/>
          </a>
        </div>
      )
    }


    render() {
        var settings ={
          slidesToShow:9,
          arrows:false,
          autoplay:true,
          autoplaySpeed:2000,
          responsive:[
            {
              breakpoint:800,
              settings: {
                slidesToShow: 5,
              }
            },
            {
              breakpoint:450,
              settings: {
                slidesToShow: 3,
              }
            },
          ]
        }

        return (
          <div className="insta-feed-wrapper">
            <div className="insta-feed-title fbas">
              Our Instagram
            </div>
            <Slider {...settings}>
              {this.renderPhotos()}
            </Slider>
          </div>
        );
    }
}
