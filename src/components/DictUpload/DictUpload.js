import React, {Component} from 'react';
import axios from 'axios';
import './DictUpload.css';
import {PostData} from "../../services/PostData";

class DictUpload extends Component {

    constructor() {
        super();
        this.state = {
            data: {languages: []}
        };
        this.handleUploadDictionary = this.handleUploadDictionary.bind(this);
        this.load = this.load.bind(this);
        this.load();
    }

    load() {
        PostData('getLanguageList', {}).then((data) => {
            if (data) {
                this.setState({
                    data: {languages: data}
                });
            }
        });
    }

    handleUploadDictionary(ev) {
        ev.preventDefault();

        const data = new FormData();
        data.append('file', this.uploadInput.files[0]);
        data.append('filename', this.fileName.value);
        data.append('language', ev.target.language.value);

        axios.post(process.env.API_URL + 'uploadDictionary', data)
            .then(function (response) {
                alert(response.data.response);
            })
            .catch(function (error) {
                alert(error);
            });
    }

    render() {
        return (
            <div className="container">
                <h3>Загрузить словарь</h3>
                <form onSubmit={this.handleUploadDictionary}>
                    <div className="form-group">
                        <input className="form-control" ref={(ref) => {
                            this.uploadInput = ref;
                        }} type="file"/>
                    </div>

                    <div className="form-group">
                        <input className="form-control" ref={(ref) => {
                            this.fileName = ref;
                        }} type="text" placeholder="Name for the filename"/>
                    </div>

                    <div className="form-group">

                        <select name="language" className="form-control">
                            {
                                this.state.data.languages.map((lang) => {
                                    return (
                                        <option value={lang}>{lang}</option>);
                                })
                            }

                        </select>
                    </div>

                    <button className="btn btn-success" type="submit">Загрузить словарь</button>
                </form>
            </div>
        );
    }
}

export default DictUpload;