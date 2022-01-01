import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';

function Example() {
    return (
        <div className="container">
          <App />  
        </div>
    );
}

export default Example;

if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}
