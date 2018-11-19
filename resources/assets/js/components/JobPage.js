import React, { Component } from 'react';
import ReactDOM from 'react-dom';


export default class JobPage extends Component {
    constructor(props){
      super(props);

      this.state={
          jobs: null
      }
    }

    componentWillMount(){

            fetch('/api/job-vacancy/'+this.props.jobid)
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    this.setState(
                        {
                            jobs:data.jobs
                        }
                    );
                });

    }

    renderReq(){

           return(
            <div className="row">
            <div className="col-md-4">
              <div className="job-key fbas">
                Periode
              </div>
            </div>
            <div className="col-md-8">
              <div className="job-key-desc">
               {this.state.jobs.period}
             </div>
            </div>

            <div className="col-md-4">
              <div className="job-key fbas">
                Lokasi
              </div>
            </div>
            <div className="col-md-8">
              <div className="job-key-desc">
              {this.state.jobs.location}
             </div>
            </div>

            <div className="col-md-4">
              <div className="job-key fbas">
              remunerasi
              </div>
            </div>
            <div className="col-md-8">
              <div className="job-key-desc">
              {this.state.jobs.renumeration}
             </div>
            </div>

            <div className="col-md-4">
              <div className="job-key fbas">
                Kualifikasi
              </div>
            </div>
            <div className="col-md-8">
              <div className="job-key-desc" dangerouslySetInnerHTML={{__html:this.state.jobs.qualification }}>
             </div>
            </div>

             <div className="col-md-4">
              <div className="job-key fbas job-respon">
                Tanggung Jawab Pekerjaan
              </div>
            </div>
            <div className="col-md-8">
              <div className="job-key-desc" dangerouslySetInnerHTML={{__html:this.state.jobs.responsibles}}>
             </div>
            </div>
          </div>
        )

    }

    render() {
        if(this.state.jobs!=null) {
            return (
                <div className="job-wrapper">
                    <div className="job-background" style={{backgroundImage :"url(/"+this.state.jobs.image+")"}}>
                        <div className="job-background-tint">
                            <div className="job-header">
                                <div className="row">
                                    <div className="col-md-6">
                                        <div className="job-header-one fbas">Vacancy</div>
                                    </div>
                                    <div className="col-md-6">
                                        <div className="job-header-two fbas">{this.state.jobs.position}</div>
                                    </div>
                                </div>
                            </div>

                            <div className="container spacing">
                                <div className="job-req-wrapper">
                                    {this.renderReq()}
                                    <div className="job-send-cv fbas">
                                        Please Send Your cv to Our Email
                                        <a className="nolink" href="mailto:recruitment@fiberstar.co.id" target="_blank"><span> recruitment@fiberstar.co.id</span></a>
                                    </div>
                                </div>
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

if (document.getElementById('job-page')) {
    const jobID = document.getElementById('job-page').dataset.id;
    ReactDOM.render(<JobPage jobid ={jobID}/>, document.getElementById('job-page'));
}
