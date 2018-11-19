import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Starimg from './Starimg';
import Timeline from './Timeline';


export default class AboutPage extends Component {
    constructor(props){
      super(props);
      this.state={
          vision:"",
          mission:"",
      };
    }

    componentDidMount(){
        fetch('/api/about-us-page')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        vision:data.vision,
                        mission:data.mission
                    }
                );
            });

        window.sr.reveal('.profile-about', {
            duration: 2000,
            origin:'top'
        });

        function mid(){
            document.getElementById("visionleft").style.display = "block";
            document.getElementById("missionright").style.display = "block";
            window.sr.reveal('.profile-vision', {
                duration: 2000,
                origin:'left'
            });
            window.sr.reveal('.profile-mission', {
                duration: 2000,
                origin:'right'
            });
        }
        setTimeout(mid, 1000);
    }

    renderAboutHeader(){
      return(
        <div className="profile-background fbas">
          <div className="profile-about mx-auto" id="aboutup">
            <div className="profile-about-text ">
              ABOUT US
            </div>
            <div className="profile-about-box mx-auto"></div>
          </div>

          <div className="profile-vision" id="visionleft">
            <div className="profile-vision-text">
              <div className="vision-text-title ">
                OUR <span>VISION</span>
              </div>
              <div className="vision-text-title-desc">  
                  {this.state.vision}
                  {/*To be the best and reliable <br></br>*/}
                  {/*Access Network Provider*/}
              </div>
            </div>
          </div>

           <div className="profile-mission" id="missionright">
            <div className="profile-mission-text">
              <div className="vision-text-title ">
                OUR <span>Mission</span>
              </div>
              <div className="vision-text-title-desc">
                  {this.state.mission}
                  {/*Connecting the future with full fiber optic network <br></br>*/}
                  {/*For endless possibilities*/}
              </div>
            </div>
          </div>


        </div>
      )
    }

    render() {
        return (
          <div className="profile-wrapper">
            {this.renderAboutHeader()}
            <Starimg  />
            <Timeline />
          </div>
        );
    }
}

if (document.getElementById('about-us')) {
    ReactDOM.render(<AboutPage />, document.getElementById('about-us'));
}
