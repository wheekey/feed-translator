import React from 'react';
import ReactDOM from 'react-dom';
import DictUpload from './DictUpload';

it('AddFeed renders without crashing', () => {
  const div = document.createElement('div');
  ReactDOM.render(<DictUpload />, div);
});