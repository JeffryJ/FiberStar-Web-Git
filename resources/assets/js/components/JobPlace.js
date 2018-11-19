import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import VacancyBox from './VacancyBox';

export default class JobPlace extends Component {
  constructor(props){
    super(props);

    this.state= {
      jobslist:[]
    }
  }

    componentDidMount() {

        fetch('api/job-vacancies')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        jobslist:data.jobslist
                    }
                );
            });
    }

    renderJobBox(){
      return this.state.jobslist.map((item, i)=>
        <div className="col-md-3" key={'job'+i}>
            <VacancyBox image={item.image} jobdesc={item.jobdesc} id={item.id}/>
        </div>
      )
    }

    render() {
        return (
            <div className="jobplace-wrapper">
              <div className="container">
                <div className="jobplace-inside">
                  <div className="jobplace-title mx-auto">Job Vacancies</div>
                  <div className="row">
                    {this.renderJobBox()}
                  </div>
                </div>
              </div>
            </div>
        );
    }
}
