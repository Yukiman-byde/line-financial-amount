import React from "react";
import {
  BrowserRouter as Router,
  Routes,
  Route,
  Link
} from "react-router-dom";
import styled from 'styled-components'

function App(){
    return(
          <Router>
              <div>
                <StyledNav>
                  <StyledLink to="/">Home</StyledLink>
                  <StyledLink to="/about">Insert</StyledLink>
                  <StyledLink to="/about">Edit</StyledLink>
                  <StyledLink to="/about">Payed</StyledLink>
                  <StyledLink to="/users">User</StyledLink>
                </StyledNav>
        
                {/* A <Switch> looks through its children <Route>s and
                    renders the first one that matches the current URL. */}
                <Routes>
                </Routes>
              </div>
           </Router>
  );
}


export default App;

const StyledNav = styled('nav')({
    height: '50px',
    width: '100%',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    textAlign: 'center',
    borderBottom: '1px solid gray',
    boxShadow: '2px 2px 2px lightgray',
    overflow: 'scroll',
});

const StyledLink = styled(Link)({
    margin: '24px', 
    textDecoration: 'none',
    color: '#00B900',
});





//   <Route path='/users' element={<UserPage />} />
//                   <Route path='/:id/insert' element={<UserPage />} />