import React, { useState, useEffect } from 'react';
import styled from 'styled-components';
import {useParams, useNavigate} from 'react-router-dom';
import Button from '@material-ui/core/Button';
import TextField from '@material-ui/core/TextField';
import LaravelApi from './LaravelApi';

function DevideComponent(){
        const [selectUsers, setSelectUsers] = useState([]);
        const [boolean, setBoolean] = useState(false);
        const { groupName } = useParams();
        const [number, setNumber] = useState(0);
        const navigate = useNavigate();
        const [users, setUsers] = useState([]);
        let count = 0;

        useEffect(() => {
          LaravelApi.get(`/getUserName/${groupName}`).then((response) => {
           console.log(response.data);
           });
        },[]);


        const HandlePost = (user) => {
        if(selectUsers.includes(user)){
         return null;
        }else{
          selectUsers.push(user);
          setBoolean(true);
        }
        console.log(selectUsers);
    };
    
      const HandleRequest = () => {
     // if(selectUsers && (count < 1)){
         count++;
         const request = {
            users: selectUsers,
            amount: number,
            groupName: groupName
         }
       LaravelApi.post(`/Divide/${groupName}`, request).then((response) => {
        navigate(`/Divide/${groupName}`);
       }).catch(error => confirm(error.message));   
     // }else{
     //  confirm('割り勘するメンバーを指名してください')
     // }
    };
    return(
          <div>
              <TitleContainer>
                <TitleStyled >割り勘した人を選んでください</TitleStyled>
              </TitleContainer>
                {users.map((user, index) => (
                <Button
                    style={{color: "white", backgroundColor: '#00B900', width: '100%', marginBottom: 16,}}
                    onClick={() => HandlePost(user)}
                    key={index}
                >
                    {user.name}
                 </Button>
                ))}
                <TextField
                 id="outlined-number"
                 label="Number"
                 type="number"
                 onChange={(e) => setNumber(e.target.value)}
                 InputLabelProps={{
                    shrink: true,
                 }}
                 variant="outlined"
            　　/>
         　     <Button
         　      onClick={()=>HandleRequest()}
         　     >
         　     決定
         　     </Button>
     　    </div>
        );
}

export default DevideComponent;

const TitleContainer = styled('div')({
 width: '100%',
 height: '30vh',
 position: 'relative',
});

const TitleStyled = styled('h3')({
 color: '#00B900',
 position: 'absolute',
 top: '50%',
 left: '50%',
 transform: 'translate(-40%, -50%)',
 whiteSpace: 'no-wrap',
});