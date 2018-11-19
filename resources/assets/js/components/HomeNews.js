import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import NewsBox from './NewsBox';


export default class HomeNews extends Component {
    constructor(props){
      super(props);

      this.state={
        news:[]
      }

    }

    componentDidMount() {
        fetch('api/landing-page-news')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        news:data.news
                    }
                );
            });
    }

    renderNews(){
      return this.state.news.map((item, i)=>
        <NewsBox image={item.image} date={item.date} title={item.title} newsdesc={item.newsdesc} newsid={item.id} key={'news'+i} />
      )
    }

    render() {
        return (
          <div className="homenews-wrapper">
            <div className="homenews-title fbas">NEWS</div>
            <div className="container">
              <div className="row">
                {this.renderNews()}
              </div>
              <div className="btn-readmore">
                <a href={location.protocol + '//' + location.host + '/news'} name="button" className="btn btnreadmore nolink" >Read More</a>
              </div>
            </div>
          </div>
        );
    }
}
