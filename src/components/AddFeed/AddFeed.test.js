import React from 'react';
import ReactDOM from 'react-dom';
import AddFeed from './AddFeed';

it('AddFeed renders without crashing', () => {
  const div = document.createElement('div');
  ReactDOM.render(<AddFeed />, div);
});