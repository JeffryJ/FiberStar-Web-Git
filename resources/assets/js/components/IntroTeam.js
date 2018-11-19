import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ConcernBox from './ConcernBox';

export default class IntroTeam extends Component {
  constructor(props) {
    super(props);

    this.state ={
      ConcernBox:[]
    }
  }

    componentWillMount() {
        fetch('api/our-team-concerns')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        ConcernBox:data.ConcernBox
                    }
                );
            });
    }

    renderConcernBox(){
      return this.state.ConcernBox.map((item,i)=>
          <div className="col-md-4" key={'div' +i}>
            <ConcernBox number={item.number} mconcern={item.mconcern} />
          </div>
        )
    }

    render() {
        return (
          <div className="intro-team-wrapper">
            <div className="intro-work-opp">
              <div className="row">
                <div className="col-md-4">
                  <div className="intro-one">
                    <div className="intro-one-a">Work</div>
                    <div className="intro-one-b">Opportunities</div>
                  </div>
                </div>
                <div className="col-md-8">
                  <div className="intro-two">
                    As a company dedicated and committed to provide reliable and quality services for customer. FiberStar holds to the highest corporate values in all of the operations, with:
                  </div>
                </div>
              </div>
            </div>

            <div className="container concern-wrapper">
              <div className="row">
                  {this.renderConcernBox()}
              </div>
            </div>
          </div>

        );
    }
}
