function validation(dataSet){
  let resultBool = true;
  for(let i=0; i <dataSet.length; i++){
    let inputType = dataSet[i][0];
    let inputName = dataSet[i][1];
    let outText = dataSet[i][2];
    if(inputType=="input" || inputType=="select" || inputType=="textarea"){
      let getValue =  document.querySelector(inputType+"[name='"+inputName+"']").value;
      let validateDiv = dataSet[i][3];
      let range = dataSet[i][4];
      switch(validateDiv){
        case "empty":
        if(getValue==""){
          alert(outText+"은(는) 필수입력 항목입니다.\n값을 입력해 주세요.");
          resultBool = false;
        }
        break;
        case "minLength":
        if(getValue.length < range){
          alert(outText+"은(는) "+range+"자 이상이어야합니다.");
          resultBool = false;
        }
        break;
        case "maxLength":
        if(getValue.length > range){
          alert(outText+"은(는) "+range+"자 이하여야합니다.");
          resultBool = false;
        }
        break;
        case "minNumber":
        if(parseFloat(getValue) < range){
          alert(outText+"은(는) "+range+"이상이어야합니다.");
          resultBool = false;
        }
        break;
        case "maxNumber":
        if(parseFloat(getValue) > range){
          alert(outText+"은(는) "+range+"이하여야합니다.");
          resultBool = false;
        }
        break;
        case "email":
        let regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
        if(regex.test(getValue) === false) {
          alert(outText+"은(는) 이메일 형식이 아닙니다.");
          resultBool = false;
        }
        break;
        case "bizNo":
        let valueMap = getValue.replace(/-/gi, '').split('').map(function(item) {
                return parseInt(item, 10);
            });

            if (valueMap.length === 10) {
                let multiply = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5);
                let checkSum = 0;

                for (let i = 0; i < multiply.length; ++i) {
                    checkSum += multiply[i] * valueMap[i];
                }

                checkSum += parseInt((multiply[8] * valueMap[8]) / 10, 10);
                if(Math.floor(valueMap[9]) !== ((10 - (checkSum % 10))% 10)){
                  alert("유효하지 않은 사업자번호입니다. 다시 확인해주세요.");
                  resultBool = false;
                }
            }
        break;
        case "date":
        let date_pattern = /[0-9]{4}-[0-9]{2}-[0-9]{2}/;
        if(!date_pattern .test(getValue)){
          alert("날짜는 yyyy-mm-dd 형식으로 입력해주세요.");
          resultBool = false;
        }

        let arrDate = getValue.split("-");
        let nYear = Number(arrDate[0]);
        let nMonth = Number(arrDate[1]);
        let nDay = Number(arrDate[2]);

        if (nYear < 1900 || nYear > 3000)
        {
          resultBool = false;
        }

        if (nMonth < 1 || nMonth > 12)
        {
          resultBool = false;
        }

        // 해당달의 마지막 일자 구하기
        let nMaxDay = new Date(new Date(nYear, nMonth, 1) - 86400000).getDate();
        if (nDay < 1 || nDay > nMaxDay)
        {
          alert("존재하지 않은 날짜를 입력하셨습니다. 다시한번 확인해주세요");
          resultBool = false;
        }
        break;
      }
    }else if(inputType=="checkbox" || inputType=="radio"){
      let getValue = document.querySelectorAll("input[name='"+inputName+"']");
      let chBool = false;
      for(let i =0; i<getValue.length;i++){
        if(getValue[i].checked==true){
          chBool = true;
        }
      }
      if(chBool== false){
        alert(outText+"은(는) 필수입력 항목입니다.\n값을 체크해 주세요.");
        return false;
      }
    }
    if(resultBool==false){
      document.querySelector(inputType+"[name='"+inputName+"']").focus();
      return resultBool;
    }
  }
  return resultBool;
}
