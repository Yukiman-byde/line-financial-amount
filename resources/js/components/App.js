import React,{useState, useEffect} from "react";
import {
  HashRouter as Router,
  Routes,
  Route,
  Link
} from "react-router-dom";
import GroupSelect from './GroupSelect';
import Edit from './Edit';
import UsersSelect from './UsersSelect';
import Drawer from '@material-ui/core/Drawer';
import styled from 'styled-components';
import List from '@material-ui/core/List';
import MenuIcon from '@material-ui/icons/Menu';
import Avatar from '@material-ui/core/Avatar';
import Divider from '@material-ui/core/Divider';
import ListItem from '@material-ui/core/ListItem';
import LaravelApi from './LaravelApi';
import Home from './Home';
import User from './User';
import Devide from './Devide';

function App(){
    const [state, setState] = useState(false);
    const [user, setUser] = useState([]);
    const [groups, setGroups] = useState([]);
    const menues = ['home', 'Insert', 'Edit', 'Divide', 'User'];
    
    useEffect(() => {
        LaravelApi.get('/AuthUser').then((response) => {
            setGroups(response.data[0]);
            setUser(response.data[1]);
        });
    },[]);
    
    
    const toggleDrawer = () => {
        setState(!state);
    };
    
    
    
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
                   <div style={{color: '#00B900'}}>Line-Amount-App</div>
                   <StyledAvatar src={user.avatar}/>
                </StyledNav>
              </div>
              <div>
                  <Drawer
                  open={state}
                  onClick={toggleDrawer}
                  >
                    <LeftDrawer />
                  </Drawer>
              </div>
              <Routes>
                  <Route exact path="/" element={<Home />} />
                  <Route exact path="/home" element={<Home />} />
              </Routes>
              <BodyStyled>
                   <Routes>
                    <Route exact path="/Insert" element={<GroupSelect groups={groups}/>} />
                    <Route exact path="/Edit" element={<GroupSelect groups={groups}/>} />
                    <Route exact path="/Divide" element={<GroupSelect groups={groups}/>} />
                    <Route exact path="/User" element={<User user={user} groups={groups}/>} />
                    <Route exact path="/Insert/:groupName" element={<UsersSelect />} />
                    <Route exact path="/Edit/:groupName" element={<Edit />} />
                    <Route exact path="/Divide/:groupName" element={<Devide />} />
                  </Routes>
              </BodyStyled>
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

const BodyStyled = styled('div')({
    width: '70%',
    marginLeft: 'auto',
    marginRight: 'auto',
    textAlign: 'center',
});



//   <Route path='/users' element={<UserPage />} />
//                   <Route path='/:id/insert' element={<UserPage />} />
//   <StyledLink to="/">Home</StyledLink>
//                   <StyledLink to="/about">Insert</StyledLink>
//                   <StyledLink to="/about">Edit</StyledLink>
//                   <StyledLink to="/about">Payed</StyledLink>
//                   <StyledLink to="/users">User</StyledLink>
            //   {/* A <Switch> looks through its children <Route>s and
            //         renders the first one that matches the current URL. */}
            //     <Routes>
            //     </Routes>
            
            
            
            // <Routes>
            //         <Route path="/group" element={<GroupSelect />} />
            //       </Routes>