import React from 'react';
import styled from 'styled-components';
import Paper from '@material-ui/core/Paper';


function Home(){
    return(
        <div>
          <HomePicture></HomePicture> 
          <HomeTitle>ようこそ</HomeTitle>
          <HomeBody elevation={10}>
          使用方法
              <div>
                １：ユーザー登録の確認
              </div>
              <div>
                ２：グループ登録がもしできていない場合はグループに戻って「登録」と打ち込もう
              </div>
              <div>
                ３：使いたい機能右上のメニューを見てクリック
              </div>
              <div>
                ４：お金と時間の使い方には気をつけて
              </div>
          </HomeBody>
          <HomeFooter></HomeFooter>
        </div>
        );
}

export default Home

const HomePicture = styled('div')({
    position: 'relative',
    width: '100%',
    height: '40vh',
    background: 'rgb(0,185,0)',
    background: 'linear-gradient(180deg, rgba(0,185,0,1) 35%, rgba(255,255,255,0.9794292717086834) 100%)',
});

const HomeTitle = styled('div')({
    position: 'absolute',
    textAlign: 'center',
    alignItems: 'center',
    top: '25%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    zIndex: 999,
    backgroundColor: '#fff',
    color: '#00b900',
    padding: '30px',
    borderRadius: '20px',
});

const HomeBody = styled(Paper)({
    top: '-20px',
    alignItems: 'center',
    textAlign: 'center',
    height: '30vh',
    width: '100%',
    backgroundColor: '#fff',
    borderRadius: '20px',
    border: '1px, solid: gray'
});

const HomeFooter = styled('div')({
    background: 'rgb(0,185,0)',
    height: '30vh',
    width: '100%',
})