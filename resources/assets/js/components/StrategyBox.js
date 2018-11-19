import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class ServicesBox extends Component {
  constructor(props) {
    super(props);
  }

    rendersbox(){
        return this.props.strategy.map((item,i)=>
        <div className="col-md-4" key={i}>
          <div className="services-strategy">
            {item}
          </div>
       </div>
        )
    }

    render() {
        return (
          <div className="row fbas">
              {this.rendersbox()}
          </div>

        );
    }
}
