import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ServicesBox from './ServicesBox';


export default class ServicesPage extends Component {
    constructor(props){
      super(props);

      this.state={
          services:null
      }
    }

    componentDidMount() {
        fetch('api/services')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        services: data.services
                    }
                );
            });
    }

    renderServices(){
        return this.state.services.map((item,i)=>
            <ServicesBox service={item.service} image={item.image} content={item.content} strategy={item.strategy} key={i}/>
        )
    }

    render() {
        if(this.state.services!=null) {
            return (
                <div>
                    <div className="services-body">
                        <div className="services-tint">
                            <div className="container">
                                <div className="services-upper fbas">
                                    FIBERSTAR <span>SERVICES</span>
                                </div>
                                {this.renderServices()}
                            </div>
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

if (document.getElementById('services-page')) {
    ReactDOM.render(<ServicesPage />, document.getElementById('services-page'));
}
