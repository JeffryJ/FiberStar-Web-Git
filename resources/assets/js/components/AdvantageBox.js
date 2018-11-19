import React, { Component } from 'react';
import ReactDOM from 'react-dom';

const img_chain= "/storage/assets/chain.png";
const img_fast=  "/storage/assets/fast.png";
const img_lock=  "/storage/assets/lock.png";
const img_world= "/storage/assets/world.png";

export default class AdvantageBox extends Component {
    constructor(props){
      super(props);
    }

    componentDidUpdate(){
        window.sr.reveal('.front-adv-box', {
            duration: 2000,
            origin:'bottom'
        });
    }

    renderAdvantageBox(){

        return this.props.benefits.map((item, i)=>
            <div key={i} className="col-md-3">
                <div className="advantage-box" id={"flip"+i}>
                    <div className="front-adv-box">
                        <img src={item.image} alt=""/>
                        <div className="adv-title">{item.title}</div>
                    </div>
                </div>
            </div>
        );
    }

    render() {
        return (

          <div className="row">
              {this.renderAdvantageBox()}

                {/*<div className="col-md-3">*/}
                  {/*<div className="advantage-box" id="flip1">*/}
                    {/*<div className="front-adv-box">*/}
                      {/*<img src={img_chain} alt=""/>*/}
                      {/*<div className="adv-title">Net Neutrality </div>*/}
                    {/*</div>*/}
                  {/*</div>*/}
                {/*</div>*/}
          </div>


        );
    }
}
