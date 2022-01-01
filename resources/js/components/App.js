import React,{useState, useEffect} from "react";
import {
  BrowserRouter as Router,
  Routes,
  Route,
  Link
} from "react-router-dom";
import Drawer from '@material-ui/core/Drawer';
import Button from '@material-ui/core/Button';
import styled from 'styled-components';
import List from '@material-ui/core/List';
import MenuIcon from '@material-ui/icons/Menu';
import Avatar from '@material-ui/core/Avatar';
import Divider from '@material-ui/core/Divider';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import LaravelApi from './LaravelApi';

function App(){
    const [state, setState] = useState(false);
    const [user, setUser] = useState([]);
    const menues = ['House', 'Insert', 'Edit', 'Payed', 'User'];
    
    useEffect(() => {
        LaravelApi.get('/AuthUser').then((response) => {
            setUser(response.data);
        })
    },[]);
    
    const toggleDrawer = () => {
        setState(!state);
    }
    
    function LeftDrawer(){
        return(
            <div
            >
                <List>
                    {menues.map((menu, index) => (
                    <div>
                        <ListItem button key={menu} key={index}>
                           <StyledLink to={menu}>{menu}</StyledLink>
                        </ListItem>
                        <Divider />
                    </div>
                    ))}
                </List>
            </div>
        );
    }
    
    
    return(
          <Router>
              <div>
                <StyledNav>
                   <MenuIcon onClick={toggleDrawer}/>
                   <div>Line-Amount-App</div>
                   <StyledAvatar src={user.avatar}/>
                </StyledNav>
        
                {/* A <Switch> looks through its children <Route>s and
                    renders the first one that matches the current URL. */}
                <Routes>
                </Routes>
              </div>
              <div>
                  <Drawer
                  open={state}
                  onClick={toggleDrawer}
                  >
                    <LeftDrawer />
                  </Drawer>
              </div>
                <PictureStyled></PictureStyled>
           </Router>
  );
}


export default App;

const StyledNav = styled('nav')({
    height: '50px',
    width: '100%',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'space-evenly',
    textAlign: 'center',
    borderBottom: '1px solid gray',
    boxShadow: '2px 2px 2px lightgray',
});

const StyledLink = styled(Link)({
    margin: '24px', 
    textDecoration: 'none',
    color: '#00B900',
});

const StyledAvatar = styled(Avatar)({
    fontSize: 20,
});


const PictureStyled = styled('div')({
    widht: '100%',
    height: '240px',
    backgroundImage: 'linear-gradient(180deg, rgba(232,249,229,0) 41%, rgba(255,255,255,0.9794292717086834) 88%), url("https://cdn.pixabay.com/photo/2017/12/17/14/12/bitcoin-3024279_1280.jpg")',
    backgroundSize: 'contain',
    backgroundRepeat: 'no-repeat',
})





//   <Route path='/users' element={<UserPage />} />
//                   <Route path='/:id/insert' element={<UserPage />} />
//   <StyledLink to="/">Home</StyledLink>
//                   <StyledLink to="/about">Insert</StyledLink>
//                   <StyledLink to="/about">Edit</StyledLink>
//                   <StyledLink to="/about">Payed</StyledLink>
//                   <StyledLink to="/users">User</StyledLink>