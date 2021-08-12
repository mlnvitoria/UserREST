using NETCoreProject.Models;
using System;
using System.Collections.Generic;
using System.Threading.Tasks;

namespace NETCoreProject.Data
{
    public class UserRepository : IRepository<User>
    {
        public Task<User> Create(User entity)
        {
            throw new NotImplementedException();
        }

        public Task<User> DeleteById(int id)
        {
            throw new NotImplementedException();
        }

        public Task<List<User>> Get()
        {
            throw new NotImplementedException();
        }

        public Task<User> GetById()
        {
            throw new NotImplementedException();
        }

        public Task<User> Update(int id, User entity)
        {
            throw new NotImplementedException();
        }
    }
}
