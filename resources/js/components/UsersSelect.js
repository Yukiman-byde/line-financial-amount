import React,{ useEffect, useState } from 'react';
import {useParams} from 'react-router-dom';
import LaravelApi from './LaravelApi';
import Button from '@material-ui/core/Button';
import ButtonHeaderStyled from './ButtonHeaderStyled';
import InputComponent from './InputComponent';

//グループが選ばれた後に選んだグループに所属しているユーザーを持ってくる
function UsersSelect(){
    const [users, setUsers] = useState([]);
    const [selectUser, setSelectUser] = useState([]);
    const [boolean, setBoolean] = useState(false);
    
    
    const {groupName} = useParams();
    
    
    useEffect(() => {
      LaravelApi.get(`/getUserName/${groupName}`).then((response) => {
       setUsers(response.data);
       });
    },[]);
    
    const HandlePost = (user) => {
        setSelectUser(user);
        setBoolean(true);
    };
    
    const handleChancel = () => {
        setSelectUser([]);
        setBoolean(false)
    };

    
    return(
        <div>
          <ButtonHeaderStyled title="誰の立替をしましたか？"/>
           {users.map((user, index) => (
           <Button
               style={{color: "white", backgroundColor: '#00B900', width: '100%', marginBottom: 16,}}
               onClick={() => HandlePost(user)}
               key={index}
           >
            {user.name}
           </Button>
           ))}
           <Button
           style={{color: "white", backgroundColor: '#00B900', width: '100%', marginBottom: 16,}}
           onClick={handleChancel}
           >キャンセル</Button>
           {boolean ? <InputComponent user={selectUser.name}/>: <div></div>}
        </div>
        );
}

export default UsersSelect;