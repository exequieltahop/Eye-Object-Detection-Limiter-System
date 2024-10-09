async function POST(url, data, dataType){
    try {
        let fetch_body;

        // set fetch_body accoring to the data type of the payload
        if(dataType == 'JSON'){
            fetch_body = {
                method: 'POST',
                headers: {'Content-Type' : 'application/json'},
                body: data
            };
        }else if(dataType == 'FORM_DATA'){
            fetch_body = {
                method: 'POST',
                body: data
            };
        }

        // fetch api end point
        const response = await fetch(url , fetch_body);

        // check connecting
        if(!response.ok){
            throw new Error("Server Error");
        }

        /**
         * get content type and check the type 
         * then return the exact parsed response 
         */
        const responseType = response.headers.get("Content-Type");

        if(responseType && responseType.includes("application/json")){
            return await response.json();
        }else if(responseType && responseType.includes("application/octet-stream")){
            return new Uint8Array(await response.arrayBuffer());
        }
        else{
            throw new Error(await response.text());
        }
    } catch (error) {
        throw error;
    }
}