import React, {Component} from 'react';
import {Redirect} from 'react-router-dom';
import {PostData} from '../../services/PostData';
import './Table.css';

class Table extends Component {

    constructor() {
        super();
        this.state = {data: {feeds: [], dictionaries: []}};
        this.load = this.load.bind(this);
        this.load();
    }

    load() {
        PostData('getFeeds', {}).then((data) => {
            if (data) {
                this.setState({data: data})
            }
        });
    }

    groupBy(xs, prop) {
        let grouped = {};
        for (let i = 0; i < xs.length; i++) {
            let p = xs[i][prop];
            if (!grouped[p]) {
                grouped[p] = [];
            }
            grouped[p].push(xs[i]);
        }
        return Object.values(grouped);
    }

    deleteFeed(feed) {
        PostData('deleteFeed', feed).then((data) => {
            console.log("Удалили фид " + data);
        });
    }

    setFeedDict(e, feed) {
        feed.dictionaries =
            PostData('setFeedDict', {
                "feedId": feed.id,
                "language": e.target.getAttribute("data-language"),
                "languageId": e.target.value
            }).then((data) => {
            });
    }

    updateFeedLink(e, feed)
    {
        PostData('updateFeedLink', {
            "feedId": feed.id,
            "feedLink": e.target.value
        }).then((data) => {
        });
    }

    render() {
        var dictGrouped = this.groupBy(this.state.data.dictionaries, "language");
        return <div className="row">
            <table className="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Feed</th>
                    <th scope="col">Словари</th>
                    <th scope="col">Ссылка на фид</th>
                    <th scope="col">Ссылка на  переведенный фид</th>
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>

                {this.state.data.feeds.map((feed, i) => {
                    return (
                        <tr>
                            <th scope="row">{feed.feedName}</th>
                            <td>
                                {dictGrouped.map((lang) => {
                                    var currentFeedLangId;
                                    return (
                                        <div className="input-group mb-3">
                                            <div className="input-group-prepend">
                                                <label className="input-group-text"
                                                       htmlFor="inputGroupSelect01">{lang[0].language}</label>
                                            </div>
                                            <select data-language={lang[0].language} className="custom-select"
                                                    id="inputGroupSelect01"
                                                    onChange={(e) => this.setFeedDict(e, feed)}>
                                                <option>Не выбрано</option>
                                                {lang.map((langDict) => {
                                                    feed.dictionaries.map((dict) => {
                                                            if (langDict.id === dict.id) {
                                                                currentFeedLangId = langDict.id;
                                                            }
                                                        }
                                                    );
                                                })
                                                }

                                                {lang.map((langDict) => {
                                                    if (langDict.id === currentFeedLangId) {
                                                        return (<option value={langDict.id}
                                                                        selected>{langDict.fileName}</option>);
                                                    }
                                                    else {
                                                        return (
                                                            <option value={langDict.id}>{langDict.fileName}</option>);
                                                    }
                                                })}

                                            </select>
                                        </div>
                                    );
                                })
                                }
                            </td>
                            <td><input className="form-control" type="text" onChange={(e) => this.updateFeedLink(e, feed)} defaultValue={feed.link}/></td>
                            <td><a href={process.env.REACT_APP_TRANSLATED_FEED_URL + feed.feedName + ".xml"}>Ссылка на перевод</a></td>

                            <td>
                                <button type="button" className="btn btn-danger"
                                        onClick={() => this.deleteFeed(feed)}>Удалить фид
                                </button>
                            </td>
                        </tr>
                    )
                })
                }
                </tbody>
            </table>
        </div>
            ;
    }
}

export default Table;