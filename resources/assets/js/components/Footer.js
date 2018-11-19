import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import FiberForm from './FiberForm';
const imglogo= "/storage/assets/fiberlogowhite.png";

export default class Footer extends Component {
    constructor(props){
      super(props);

      this.state = {
          company_name : "PT. Mega Akses Persada",
          address : "<p>Menara Kadin Indonesia Lt. 6</p><p>Jl. H. R. Rasuna Said X-5 Kav. 2-3</p><p>Jakarta Selatan 12950</p><p>Indonesia</p>",
          phone : "+62-21-8062-1200",
          fax : "+62-21-8062-1299",
          customer_care: "",
          socmeds : []
      };

    }

    componentDidMount(){

        fetch('/api/main-data')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        company_name:data.company_name,
                        address:data.address,
                        phone:data.phone,
                        fax:data.fax,
                        customer_care: data.customer_care
                    }
                );
            });

        fetch('/api/social-media')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        socmeds:data.socmeds
                    }
                );
            });
    }

    renderSocialMedia(){
        return this.state.socmeds.map((item, i)=>
            <li key={i}><a href={item.url}> <img src={'/'+item.icon_image_link} alt=""/></a></li>
        )
    }

    render() {
        return (

          <div className="footer-wrapper" id="fiberstar-footer">
            <div className="container">
                <div className="row">

                  <div className="col-md-6">
                    <img src="/storage/assets/fiberlogotrans.png" alt=""/>
                    <div className="fiberstar-address"
                         dangerouslySetInnerHTML={{__html:
                            this.state.company_name+ "<br/>"+
                            this.state.address+ "<br/>"+
                            "<p>P: "+this.state.phone+ "<br/>"+
                            "F: "+this.state.fax+ "</p>"
                         }}>
                    </div>
                      <div>
                          <img src={'/'+this.state.customer_care}/>
                      </div>
                    <div className="footer-social">
                      <ul>
                          {this.renderSocialMedia()}
                      </ul>
                    </div>
                  </div>

                  <div className="col-md-6">
                    <div className="form-title">
                      Contact Us
                    </div>
                    <FiberForm />
                  </div>

                </div>

            </div>
          </div>

      );
    }
}

if (document.getElementById('foo-ter')) {
    ReactDOM.render(<Footer />, document.getElementById('foo-ter'));
}
