import React from 'react';
import styled from 'styled-components';

function RedirectToHome(){
    return(
        <Container>
         　設定が完了しました。ホームに戻ってください。
        </Container>
        );
}

export default RedirectToHome;

const Container = styled('div')({
    width: '80%',
    marginLeft: 'auto',
    marginRight: 'auto',
    backgroundColor: 'Aquamarine',
    color: '#fff',
});