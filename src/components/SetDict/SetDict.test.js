import React from 'react';
import ReactDOM from 'react-dom';
import SetDict from './SetDict';

it('SetDict renders without crashing', () => {
  const div = document.createElement('div');
  ReactDOM.render(<SetDict />, div);
});