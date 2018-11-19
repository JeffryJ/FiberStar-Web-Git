import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import TestimonialBox from './TestimonialBox';

export default class Testimonial extends Component {
    constructor(props){
      super(props);

      this.state={
        testimonials:[
          // {
          //     image: "/storage/assets/bg.jpg",
          //     name:"My name Here",
          //     testimonial:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum molestias, voluptate illo."
          // },
          // {
          //     image: "/storage/assets/bg.jpg",
          //     name:"My name Here",
          //     testimonial:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum molestias, voluptate illo."
          // },
          // {
          //     image: "/storage/assets/bg.jpg",
          //     name:"My name Here",
          //     testimonial:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum molestias, voluptate illo."
          // },
        ]
      }

    }

    componentDidMount() {
        fetch('api/testimonials')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        testimonials: data.testimonials
                    }
                );
            });
    }

    renderTestimonialBox(){
      return this.state.testimonials.map((item,i)=>
        <TestimonialBox image={item.image} name={item.name} testimonial={item.testimonial} key={'testi'+i}/>
      )
    }

    render() {
        return (
          <div className="testimonial-wrapper">
            <div className="testimonial-title fbas">Testimonial</div>
              <div className="container">
               <div className="testimonial-box-wrapper">
                 <div className="row">
                    {this.renderTestimonialBox()}
                 </div>
             </div>
            </div>
          </div>

        );
    }
}
