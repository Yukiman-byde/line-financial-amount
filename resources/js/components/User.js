import React, {useEffect, useState} from 'react';
import styled from 'styled-components';
import Avatar from '@material-ui/core/Avatar';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import LaravelApi from './LaravelApi';

function User({user, groups}){
    const [groupNumber, setGroupNumber] = useState();
   // console.log(groups.length);
    
    useEffect(() => {
        LaravelApi.get('/amounts').then((response) => {
            console.log(response.data);
        })
    },[]);
    
    return(
        <UserContainer>
           <Avatar style={{marginLeft: 'auto', marginRight : 'auto', top: '-20px', width: 70, height: 70,}} src={user.avatar}/>
           <p>名前：<span style={{color: '#00B900'}}>{user.name}</span></p>
           <ComponentsContainer>
             <Table>
              <TableHead>
                <TableRow>
                   <TableCell>グループ数</TableCell>
                   <TableCell>未払い数</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                   <TableRow>
                     <TableCell>{groups.length}</TableCell>
                     <TableCell>2</TableCell>
                   </TableRow>
              </TableBody>
             </Table>
           </ComponentsContainer>

        </UserContainer>
        );
}

export default User;

const UserContainer = styled('div')({
    marginTop: 55,
    backgroundColor: 'whitesmoke',
    height: '40vh',
    width: '100%',
    border: '0.1px solid lightgray',
    borderRadius: 20,
    position: 'relative',
});

const ComponentsContainer = styled(TableContainer)({
    position: 'absolute',
    border: '1px solid #00B900',
    borderRadius: '20px',
    bottom: 0,
});
