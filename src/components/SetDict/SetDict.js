import React, {Component} from 'react';
import {Redirect} from 'react-router-dom';
import {PostData} from '../../services/PostData';
import './SetDict.css';

class SetDict extends Component {

    constructor() {
        super();
        this.state = {data: {feeds: [], dictionaries: []}}
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

    deleteFeed(feed) {
        PostData('deleteFeed', feed).then((data) => {
            console.log("Удалили фид " + data);
        });
    }

    render() {
        return (
            <div>

            </div>
        );
    }
}

export default SetDict;