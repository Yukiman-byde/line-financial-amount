import React, { useState, useEffect } from 'react';
import styled from 'styled-components';
import Result from './Result';
import LaravelApi from './LaravelApi';
import {useParams} from 'react-router-dom';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';

function Edit(){
    const [amounts, setAmounts] = useState([]);
    const [userNames, setUserNames] = useState([]);
    const {groupName} = useParams();
    
    useEffect(() => {
       LaravelApi.get(`/results/${groupName}`).then((response) => {
           //setAmounts(response.data.amount);
          setUserNames(response.data.user_name);
          //console.log(response.data.user_name);
          setAmounts(response.data.amount);
       });
    },[]);

    return(
         <TableContainerStyled>
         <h3 style={{color: '#00B900'}}>詳細表</h3>
              <Table>
                    <TableHead>
                         <TableRowStyled>
                             <TableCellStyled style={{minWidth: '50px'}}>名前</TableCellStyled>
                             <TableCellStyled style={{minWidth: '50px'}}>金額</TableCellStyled>
                             <TableCellStyled style={{minWidth: '50px'}}>内容</TableCellStyled>
                             <TableCellStyled style={{minWidth: '50px'}}>払い済み</TableCellStyled>
                             <TableCellStyled style={{minWidth: '50px'}}>日付</TableCellStyled>
                             <TableCellStyled style={{minWidth: '50px'}}>編集</TableCellStyled>
                         </TableRowStyled>
                    </TableHead>
                    <TableBody>
                       {amounts.map((amount, index) => (
                         <Result amount={amount} userNames={userNames}  index={index} userNames={userNames}/>
                       ))}
                    </TableBody>
              </Table>
        </TableContainerStyled>
        );
}
export default Edit;



const TableContainerStyled = styled(TableContainer)({
    maxWidth: '340px',
});

const TableRowStyled = styled(TableRow)({
    overflow: 'hidden',
});

const TableCellStyled = styled(TableCell)({
    minWidth: '50px',
});
