import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';
import Table from './components/Table/Table';
import DictUpload from './components/DictUpload/DictUpload';
import AddFeed from "./components/AddFeed/AddFeed";

class App extends Component {
  render() {

    return (
      /*<div className="App">
        <div className="App-header">
          <img src={logo} className="App-logo" alt="logo" />
          <h2>Welcome to React</h2>
        </div>
        <p className="App-intro">
          To get started, edit <code>src/App.js</code> and save to reload.
        </p>
      </div>*/
        <div className="container">
            <h1>Feed Translator</h1>

            <Table/>
            <DictUpload/>
            <AddFeed/>
        </div>
    );
  }
}

export default App;
