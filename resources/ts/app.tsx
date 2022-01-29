import React, { useState } from 'react';
import ReactDOM from 'react-dom';


    const Example:React.FC= () => {
        const [ count, setCount ] = useState<number>(0)
        return(
            <div>
               <div>{ count }</div>
               <div onClick={() => setCount(count + 1)}>+</div>
               <div onClick={() => setCount(count - 1)}>-</div>
            </div>
            );
    }


if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}