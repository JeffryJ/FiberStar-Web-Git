import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import StrategyBox from './StrategyBox';

export default class ServicesBox extends Component {
	constructor(props) {
    	super(props);
  	}

    render() {
        return (
          	<div>
				<div className="services-mid-content">
					<button className="accordion" >
						<div className="accordion-header-content">
							<div className="accordion-header-content-left fbas">
								{this.props.service}
							</div>
							<div className="accordion-header-content-right" >
								<i className="fas fa-chevron-down" id="pop1"></i>
							</div>
						</div>
					</button>
					<div className="accordion-panel">
						<div className="accordion-panel-up">
							<div className = "services-thumb-isi">
								<img src={this.props.image}/>
								<div className="service-desc" dangerouslySetInnerHTML={{__html:this.props.content}}></div>
							</div>
						</div>
						<br></br>
						<div className="accordion-panel-bottom row">
							<div className = "mx-auto services-thumb-mid col-md-12 col-xs-12">
								THE IMPACT OF THIS SERVICE ON YOUR BUSINESS STRATEGY
							</div>
							<br></br>

							<div className="mx-auto col-md-12 col-xs-12">
								<StrategyBox strategy={this.props.strategy}/>
							</div>
						</div>
					</div>
				</div>
          	</div>
        );
    }
}
