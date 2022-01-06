import React, {useState, useEffect} from 'react';
import styled from 'styled-components';
import { useNavigate } from "react-router-dom";
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Checkbox from '@material-ui/core/Checkbox';
import Modal from '@material-ui/core/Modal';
import SendIcon from '@material-ui/icons/Send';
import Button from '@material-ui/core/Button';
import LaravelApi from './LaravelApi';


function Result({amount, index, userNames}){
    const [state, setState] = useState(false);
    const navigate = useNavigate();
    const [exclude, setExclude] = useState([]);
    const [userName, setUserName] = useState([]);
    const [payed, setPayed] = React.useState(false);


    const HandlePayed = (amount) => {
         if(payed === false){
            const answer = confirm('払い済みにするとデータから消されます。いいですか？');
            if(answer === true){
                setPayed(!payed);
                const request = {
                    id: amount.id,
                }
                LaravelApi.post('/Edit/delete', request).then((response) => {
                    //なんらかの処理
                    window.location.reload();
                }).catch(error => {
                    confirm(error.message);
                });
            }else{
                setPayed(payed);
            }
         }
    };
    
    
    const body = (
        <StyledPaper>
          <h2 style={{color: '#00B900', margin: 10}}>編集</h2>
          <divTable>
           
           <Button
            onClick={() => setState(!state)}
            variant="contained"
            color="primary"
            endIcon={<SendIcon />}
          >
            再設定
          </Button>       
          </divTable>
        </StyledPaper>
    );
    
    
    return(
         <TableRowStyled>
             <TableCellStyled>{userNames[index].name}</TableCellStyled>
             <TableCellStyled>{amount.amount}</TableCellStyled>
             <TableCellStyled>{amount.content}</TableCellStyled>
             <TableCellStyled>
                 <Checkbox 
                 checked={payed}
                 onClick={() => HandlePayed(amount)}
                 inputProps={{ 'aria-label': 'primary checkbox' }}
                 />
             </TableCellStyled>
             <TableCellStyled>{amount.created_at}</TableCellStyled>
             <TableCellStyled>
                 <Checkbox 
                 checked={state}
                 onClick={() => setState(!state)}
                 inputProps={{ 'aria-label': 'primary checkbox' }}
                 />
             </TableCellStyled>
             <Modal
                open={state}
                onClose={() => setState(!state)}
                >
                {body}
            </Modal>
         </TableRowStyled>
    );
}

export default Result;


const TableContainerStyled = styled(TableContainer)({
    maxWidth: '340px',
});

const TableRowStyled = styled(TableRow)({
    position: 'relative',
    overflow: 'hidden',
});

const TableCellStyled = styled(TableCell)({
    minWidth: '100px',
});

const StyledPaper = styled('div')({
    width: '90%',
    height: '60%',
    backgroundColor: '#fff',
    borderRadius: '10px',
    color: '#aaa',
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    textAlign: 'center',
    alignItems: 'center',
});

const divTable = styled('div')({
    
});