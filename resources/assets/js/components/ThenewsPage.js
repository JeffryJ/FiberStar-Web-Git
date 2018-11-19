import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class ThenewsPage extends Component {
    constructor(props){
      super(props);

      this.state={
          news: null
              // {
              //   title:"FIBERSTAR DUKUNG HADIRNYA GOOGLE",
              //   image: "/storage/assets/bg.jpg",
              //   newsdesc:"Google Station yang bekerjasama dengan FiberStar selaku penyedia jaringan infrastruktur, kembali menambah jumlah lokasinya di Indonesia. Di bulan Juli ini, direncanakan untuk diluncurkan Google Station di kota Medan, Sumatera Utara. Sejumlah fasilitas publik di beberapa lokasi strategis di Kota Medan kini akan dilengkapi dengan keberadaan Google Station seperti di Rumah Sakit Umum (RSU) Dr. Pirngadi, Universitas Medan Area, University HKBP Nommensen, STT Harapan Medan, STMIK Triguna Dharma hingga di beberapa pusat perbelanjaan seperti Cambridge City Square dan Focal Point Medan. Peluncuran perdana Google Station di Kota Medan ini ditargetkan mencapai belasan lokasi dan akan live sebelum Agustus 2018. "
              // }

      }
    }


    componentDidMount(){
        fetch('/api/news/'+this.props.newsid)
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



    render() {
        if(this.state.news) {
            return (
                <div className="thenews-wrapper">
                    <div className="container">
                        <div className="the-news-title fbas">
                            {this.state.news.title}
                        </div>
                        <div className="thenews-img mx-auto">
                            <img src={'/' + this.state.news.image} alt=""/>
                        </div>
                        <div className="thenews-desc" dangerouslySetInnerHTML={{__html: this.state.news.newsdesc}}></div>
                    </div>
                </div>
            );
        }
        else{
            return(
                <div className="thenews-wrapper">
                    <div className="loading-container-black">
                        <i className="fas fa-spinner fa-spin" style={{fontSize:"30px",verticalAlign:"middle"}}></i>
                    </div>
                </div>
            );
        }
    }
}

if (document.getElementById('the-news-page')) {
    const id = document.getElementById('the-news-page').dataset.id;
    ReactDOM.render(<ThenewsPage newsid = {id}/>, document.getElementById('the-news-page'));
}
