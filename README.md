# GrogBase
GrogBase is a platform where users can rate and discover new wines and wineries. A perfect oppurtunity for adventure and to get exposed to new cultures!

# Usage
Firstly, clone the repository to a folder where PHP files can be hosted:
```bash
git clone https://github.com/S3BzA/GrogBase
```
**NOTE**: In order for this application to work, you need a way to host PHP files. An example of such a tool is XAMPP (https://www.apachefriends.org)

Inside of the `frontend` folder, install all `npm` dependencies needed for the frontend
```bash
npm install
```

Then, modify `src/environments/environment.ts` to specify the URL to the backend API
```typescript
export const environment = {
  production: false,
  apiEndpoint: "http://localhost/clone/path/backend/src/API.php"
};
```

Finally, to start up the front end simply run:
```bash
npm run start
```
From there, the website should be available at http://localhost:4200/

