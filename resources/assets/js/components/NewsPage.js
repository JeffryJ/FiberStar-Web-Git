import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import NewsBox from './NewsBox';
import NewsLetterBox from './NewsLetterBox';

const newsIncrement = 6;
const newsletterIncrement = 5;

export default class NewsPage extends Component {
    constructor(props){
      super(props);

      this.state={
        news:null,
        newsletter:null,
        news_visible:6,
        newsletter_visible: 5
      };

        this.loadMoreNews = this.loadMoreNews.bind(this);
        this.loadMoreNewsletter = this.loadMoreNewsletter.bind(this);
    }

    loadMoreNews(){
        this.setState(
            {
                news_visible:this.state.news_visible + newsIncrement
            });
    }

    loadMoreNewsletter(){
        this.setState(
            {
                newsletter_visible:this.state.newsletter_visible + newsletterIncrement
            });
    }

    componentDidMount() {
        fetch('api/news-page')
            .then(response => {
                return response.json();
            })
            .then(data => {
                this.setState(
                    {
                        news:data.news,
                        newsletter:data.newsletter
                    }
                );
            });
    }

    renderNews(){
        if(this.state.news!=null){
            return (
                <div className="container">
                    <div className="row">
                        {
                            this.state.news.slice(0,this.state.news_visible).map((item, i)=>
                                <NewsBox image={item.image} date={item.date} title={item.title} newsdesc={item.newsdesc} newsid={item.id} key={'news'+i}/>
                            )
                        }
                    </div>
                    <div className="btn-readmore">
                        <button className="btn btn-white" onClick={this.loadMoreNews}>Load More</button>
                    </div>
                </div>
            );
        }
        else{
            return (
                <div className="loading-container-white">
                    <i className="fas fa-spinner fa-spin" style={{fontSize:"30px",verticalAlign:"middle"}}></i>
                </div>
            );
        }

    }

    renderNewsLetter(){
        if(this.state.news!=null){
            return(
                <div className="col-md-6">
                    <div className="newsletter-table">
                        <table className="table table-hover table-sm">
                            <thead className="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Volume</th>
                                <th>Modified Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            {
                                this.state.newsletter.slice(0,this.state.newsletter_visible).map((item, i)=>
                                    <NewsLetterBox volimg={item.volimg} volume={item.volume} dateletter={item.dateletter} key={'newsletter'+i}/>
                                )
                            }
                            </tbody>
                        </table>
                    </div>
                    <div className="btn-readmore">
                        <button className="btn btnreadmore" onClick={this.loadMoreNewsletter}>Load More</button>
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

    render() {
        return (
          <div className="news-page-wrapper">
            <div className="news-page-inside">
              <div className="container">
                <div className="news-page-title">NEWS
                  <div className="news-page-divider"> </div>
                  <div className="news-page-line"></div>
                </div>
                  {this.renderNews()}
              </div>
            </div>

            <div className="newsletter-wrapper">
              <div className="container">
                <div className="newsletter-title fbas">NEWSLETTER</div>
                <div className="row">
                    {this.renderNewsLetter()}
                  <div className="col-md-6">
                    <div className="newsletter-img">
                      <div className="newsletter-img-logo"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

        );
    }
}

if (document.getElementById('news-page')) {
    ReactDOM.render(<NewsPage />, document.getElementById('news-page'));
}
