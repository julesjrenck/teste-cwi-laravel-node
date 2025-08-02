const express = require('express');
const app = express();
const PORT = 3001;

app.get('/api/info', (req, res) => {
  res.json({
    service: 'mock-service',
    version: '1.0',
    status: 'running'
  });
});

app.listen(PORT, () => {
  console.log(`Mock service running at http://localhost:${PORT}`);
});
