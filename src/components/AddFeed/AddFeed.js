import React, {Component} from 'react';
import axios from 'axios';
import './AddFeed.css';
import {PostData} from "../../services/PostData";

class AddFeed extends Component {

    constructor() {
        super();
        this.state = {
            data: {languages: []}
        };
        this.addFeed = this.addFeed.bind(this);
    }

    addFeed(ev) {
        ev.preventDefault();

        const data = new FormData();
        data.append('feedName', this.feedName.value);

        axios.post(process.env.API_URL + 'addFeed', data)
            .then(function (response) {
                alert(response.data.response);
            })
            .catch(function (error) {
                alert(error);
            });
    }

    render() {
        return (
            <div className="container mt-4">
                <h3>Добавить фид</h3>
                <form onSubmit={this.addFeed}>

                    <div className="form-group">
                        <input className="form-control" ref={(ref) => {
                            this.feedName = ref;
                        }} type="text" placeholder="feedname"/>
                    </div>

                    <button className="btn btn-success" type="submit">Добавить фид</button>
                </form>
            </div>
        );
    }
}

export default AddFeed;