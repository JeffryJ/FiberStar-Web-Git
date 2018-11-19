import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ActivitySlider from './ActivitySlider';
import WhoWeAre from './WhoWeAre';
import Testimonial from './Testimonial';
import HomeNews from './HomeNews';
import InstaSlider from './InstaSlider';

export default class HomePage extends Component {
    constructor(props){
      super(props);
      this.state = {
            background_image_link:"",
            who_we_are:"",
            benefits:[]
      };
    }

    componentWillMount(){
        fetch('/api/landing-page')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        background_image_link:data.background_image_link,
                        who_we_are:data.who_we_are,
                        benefits:data.benefits
                    }
                );
            });


    }

    componentDidMount(){
        window.sr.reveal('.peanut-wrapper', {
            duration: 2000,
            origin:'bottom',
        });
        function midhome(){
            document.getElementById("text").style.display = "block";
            window.sr.reveal('.peanut-text-wrapper', {
                duration: 2000,
                origin:'top'
            });
        }
        setTimeout(midhome, 1000);
    }

    renderHeader(){
      return(
        <div className="header-animation-wrapper" style={{backgroundImage: "url(/"+this.state.background_image_link+")"}}>
          <div className="peanut-wrapper mx-auto">
					  <div className="peanut-text-wrapper" id="text">
						<div className="peanut-text fbas">Connecting</div> 
						<div className="peanut-text fbas"> 
						   <span>Indonesia</span>
						</div>
					  </div>	
			  	</div>
        </div>
      )
    }

    render() {
        return (
          <div>
            {this.renderHeader()}
            <WhoWeAre text_data={this.state.who_we_are} benefits={this.state.benefits}/>
            <Testimonial />
            <HomeNews />
            <InstaSlider />
          </div>
        );
    }
}

if (document.getElementById('home-page')) {
    ReactDOM.render(<HomePage />, document.getElementById('home-page'));
}
